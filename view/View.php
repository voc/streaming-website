<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;

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
	 * View constructor.
	 * @param Router $router
	 */
	public function __construct(Router $router)
	{
		$this->router = $router;
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
	public function outputHeaders()
	{
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
	public function outputBody()
	{
		echo $this->render();

		return $this;
	}
}
