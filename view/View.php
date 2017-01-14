<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;

abstract class View
{
	private $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	protected function createPageTemplate()
	{
		$filename = $this->getPageTemplateFilename();

		$tpl = new PhpTemplate($filename);
		$tpl = $this->configureTemplate($tpl);

		return $tpl;
	}

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

	protected function getPageTemplateFilename()
	{
		return 'template/page.phtml';
	}



	protected function setHeader($k, $v)
	{
		$this->headers[$k] = $v;

		return $this;
	}

	public function getHeader($k)
	{
		return @$this->headers[$k];
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function outputHeaders()
	{
		foreach($this->getHeaders() as $k => $v)
		{
			header("$k: $v");
		}

		return $this;
	}



	public abstract function render();

	public function outputBody()
	{
		echo $this->render();

		return $this;
	}
}
