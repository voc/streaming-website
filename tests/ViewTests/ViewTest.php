<?php
namespace C3VOC\StreamingWebsite\Tests;

trait ViewTest
{
	private $conference;

	private function setConference($conference)
	{
		$this->conference = $conference;
	}

	private function setGetParams($params) {
		$_GET = $params;
	}

	private function initializeTemplate()
	{
		$route = 'test';
		$conference = $this->conference;

		$tpl = new \PhpTemplate('template/page.phtml');
		$tpl->set(array(
			'baseurl' => forceslash(baseurl()),
			'route' => $route,
			'canonicalurl' => forceslash(baseurl()).forceslash($route),
			'assemblies' => 'template/assemblies/',
			'assets' => forceslash('assets'),
			'conference_assets' => '',

			'conference' => $conference,
		));

		if(startswith('//', @$GLOBALS['CONFIG']['BASEURL']))
		{
			$tpl->set(array(
				'httpsurl' => forceslash(forceslash('https:'.$GLOBALS['CONFIG']['BASEURL']).@$GLOBALS['MANDATOR']).forceslash($route).url_params(),
				'httpurl' =>  forceslash(forceslash('http:'. $GLOBALS['CONFIG']['BASEURL']).@$GLOBALS['MANDATOR']).forceslash($route).url_params(),
			));
		}

		return $tpl;
	}

	private function executeView($name)
	{
		ob_start();

		$conference = $this->conference;
		$tpl = $this->initializeTemplate();

		require(joinpath([
			'view',
			$name
		]));

		return ob_get_clean();
	}
}
