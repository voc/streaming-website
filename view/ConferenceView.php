<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Model\Conference;
use C3VOC\StreamingWebsite\Model\GenericConference;

abstract class ConferenceView extends View
{
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
