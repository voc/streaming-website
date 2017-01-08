<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Model\Conference;

abstract class AbstractView
{
	public function __construct(Conference $conference)
	{
		$this->conference = $conference;
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
			'baseurl' => forceslash(baseurl()),
			'assemblies' => 'template/assemblies/',
			'assets' => forceslash('assets'),
			'conference_assets' => '',

			'canonicalurl' => joinpath([
				baseurl(),
				$GLOBALS['ROUTE'],
			]),

			'conference' => $this->conference,
		]);

		if(startswith('//', @$GLOBALS['CONFIG']['BASEURL']))
		{
			$tpl->set([
				'httpsurl' => joinpath([
					'https:'.$GLOBALS['CONFIG']['BASEURL'],
					$GLOBALS['MANDATOR'],
					$GLOBALS['ROUTE']
				]).url_params(),
				'httpurl' => joinpath([
					'http:'. $GLOBALS['CONFIG']['BASEURL'],
					$GLOBALS['MANDATOR'],
					$GLOBALS['ROUTE']
				]).url_params(),
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
