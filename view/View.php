<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;
use C3VOC\StreamingWebsite\Lib\PhpTemplate;

abstract class View
{
	/**
	 * @var Router
	 */
	private $router;

	/**
	 * @var array
	 */
	private $headers = [];

	/**
	 * @var string
	 */
	private $httpResponse = null;

	/**
	 * View constructor.
	 * @param Router $router
	 */
	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	/**
	 * @param $route
	 */
	public function setRedirectHeader($route)
	{
		$this->setHeader('Location', joinpath([baseurl(), $route]));
	}

	/**
	 * @return PhpTemplate
	 */
	protected function createPageTemplate()
	{
		$filename = $this->getPageTemplateFilename();

		$tpl = new PhpTemplate($filename);
		$tpl = $this->configureTemplate($tpl);

		return $tpl;
	}

	/**
	 * @param PhpTemplate $tpl
	 * @return PhpTemplate
	 */
	protected function configureTemplate(PhpTemplate $tpl)
	{
		$tpl->set([
			'baseurl' => $this->router->getBaseUrl(),
			'assemblies' => 'template/assemblies/',
			'assets' => forceslash('assets'),
			'conference_assets' => '',
			'isPreviewEnabled' => $this->router->isPreviewEnabled(),

			'canonicalurl' => $this->router->getCanonicalUrl(),
		]);

		if($this->router->isTlsSwitcherEnabled())
		{
			$tpl->set([
				'httpsurl' => $this->router->getHttpsUrl(),
				'httpurl' => $this->router->getHttpUrl(),
			]);
		}

		return $tpl;
	}

	/**
	 * @return string
	 */
	protected function getPageTemplateFilename()
	{
		return 'template/page.phtml';
	}

	/**
	 * @return Router
	 */
	public function getRouter()
	{
		return $this->router;
	}

	/**
	 * @param $k string
	 * @param $v string
	 * @return $this
	 */
	protected function setHeader($k, $v)
	{
		$this->headers[$k] = $v;

		return $this;
	}

	/**
	 * @param $httpResponse string
	 */
	public function setHttpResponse($httpResponse)
	{
		$this->httpResponse = $httpResponse;
	}

	/**
	 * @param $k string
	 * @return string
	 */
	public function getHeader($k)
	{
		return @$this->headers[$k];
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @return $this
	 */
	private function outputHeaders()
	{
		if($this->httpResponse)
		{
			header($this->httpResponse);
		}

		foreach($this->getHeaders() as $k => $v)
		{
			header("$k: $v");
		}

		return $this;
	}


	/**
	 * @return string
	 */
	public abstract function render();


	/**
	 * @return $this
	 */
	public function output()
	{
		$body = $this->render();
		$this->outputHeaders();

		echo $body;

		return $this;
	}
}
