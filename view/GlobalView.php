<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Model\GenericConference;

abstract class GlobalView extends AbstractView
{
	public function __construct()
	{
		parent::__construct(new GenericConference());
	}
}
