<?php

namespace C3VOC\StreamingWebsite\Lib;

use C3VOC\StreamingWebsite\View;

class Router
{
	const ROUTES = [
		''                      => View\Frontpage::class,
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
		$routes = Router::ROUTES;
		if(!isset($routes[$this->route]))
		{
			throw new NotFoundException();
		}

		$viewClass = $routes[$this->route];
		if(!class_exists($viewClass)) {
			throw new \Exception('Unknown View-Class in Router-Configuration: '.$viewClass);
		}

		if(is_subclass_of($viewClass, View\ConferenceView::class))
		{
			// FIXME select Conference
			// FIXME set Conference open if Router says so
			return new $viewClass($this, null);
		}
		elseif(is_subclass_of($viewClass, View\View::class))
		{
			return new $viewClass($this);
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