<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Model\Conferences;

class AllConferences
{
	public function action() {
		return 'Lala';
	}

	/**
	 * @return string
	 */
	public function render()
	{
		$tpl = $this->createPageTemplate();
		return $tpl->render(array(
			'page' => 'allconferences',
			'title' => 'Multiple Conferences',

			'conferences' => Conferences::getActiveConferences(),
		));
	}
}
