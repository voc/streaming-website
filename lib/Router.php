<?php

namespace C3VOC\StreamingWebsite\Lib;

use C3VOC\StreamingWebsite\Model\Conferences;
use C3VOC\StreamingWebsite\View;

class Router
{
	const ROUTES = [
		''                      => View\Frontpage::class,
		'([^/+]+)'              => View\Overview::class,
		'gen/main.css'          => View\GlobalCssView::class,
		'streams/v1.json'       => View\StreamsJsonV1::class,
		'streams/v2.json'       => View\StreamsJsonV2::class,
	];

	/**
	 * @var bool
	 */
	private $forceopen;

	/**
	 * @var string
	 */
	private $route;

	public function __construct($route)
	{
		$pieces = parse_url($route);
		$route = isset($pieces['path']) ? $pieces['path'] : '';
		$this->route = rtrim($route, '/');

		$this->forceopen = isset($_GET['forceopen']);
	}

	/**
	 * @return View\View
	 */
	public function createView()
	{
		$viewClass = null;
		$params = [];

		$routes = Router::ROUTES;
		foreach($routes as $route => $routeViewClass)
		{
			if(!preg_match('@^'.$route.'$@', $this->route, $m))
				continue;

			$viewClass = $routeViewClass;
			$params = array_slice($m, 1);
			break;
		}
		if(!$viewClass)
		{
			throw new NotFoundException();
		}

		if(!class_exists($viewClass)) {
			throw new \Exception('Unknown View-Class in Router-Configuration: '.$viewClass);
		}

		if(is_subclass_of($viewClass, View\ConferenceView::class))
		{
			if(count($params) < 1)
				throw new \Exception('Conference-View-Class invoked without Conference-Slug in Route-Pattern: '.$viewClass);

			$slug = array_shift($params);
			$conference = Conferences::getConference($slug);

			if(!$conference)
				throw new NotFoundException("Conference $slug not found!");

			return new $viewClass($this, $conference, $params);
		}
		elseif(is_subclass_of($viewClass, View\View::class))
		{
			return new $viewClass($this, $params);
		}

		else throw new \Exception('Class is no View-Class: '.$viewClass);
	}

	/**
	 * @return bool
	 */
	public function isForceopen()
	{
		return $this->forceopen;
	}

	/**
	 * @param bool $forceopen
	 * @return Router
	 */
	public function setForceopen($forceopen)
	{
		$this->forceopen = $forceopen;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @param string $route
	 * @return Router
	 */
	public function setRoute($route)
	{
		$this->route = $route;
		return $this;
	}

	public function getBaseUrl()
	{
		// FIXME move logic to generate Baseurl completely here
		return forceslash(baseurl());
	}

	public function getCanonicalUrl()
	{
		return joinpath([
			$this->getBaseUrl(),
			$this->getRoute(),
		]);
	}

	public function isTlsSwitcherEnabled()
	{
		return startswith('//', @$GLOBALS['CONFIG']['BASEURL']);
	}

	public function getHttpsUrl()
	{
		if (!$this->isTlsSwitcherEnabled())
			return null;

		return joinpath([
				'https:' . $GLOBALS['CONFIG']['BASEURL'],
				$GLOBALS['MANDATOR'],
				$GLOBALS['ROUTE']
			]) . url_params();
	}

	public function getHttpUrl()
	{
		if (!$this->isTlsSwitcherEnabled())
			return null;

		return joinpath([
			'http:'. $GLOBALS['CONFIG']['BASEURL'],
			$GLOBALS['MANDATOR'],
			$GLOBALS['ROUTE']
		]).url_params();
	}

	public function isPreviewEnabled() {
		if($this->isForceopen())
			return true;

		if(isset($GLOBALS['CONFIG']['PREVIEW_DOMAIN']) && $GLOBALS['CONFIG']['PREVIEW_DOMAIN'] == $_SERVER['SERVER_NAME'])
			return true;

		return false;
	}
}
