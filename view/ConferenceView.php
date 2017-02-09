<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;
use C3VOC\StreamingWebsite\Model\Conference;
use C3VOC\StreamingWebsite\Lib\PhpTemplate;

abstract class ConferenceView extends View
{
	private $conference;

	/**
	 * @return \C3VOC\StreamingWebsite\Model\Conference
	 */
	public function getConference()
	{
		return $this->conference;
	}

	public function __construct(Router $router, Conference $conference)
	{
		parent::__construct($router);
		$this->conference = $conference;
	}

	protected function configureTemplate(PhpTemplate $tpl)
	{
		$tpl = parent::configureTemplate($tpl);
		$tpl->set([
			'conference' => $this->conference,
		]);
		return $tpl;
	}


}
