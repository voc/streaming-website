<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Model\Conferences;

class Frontpage extends View
{
	/**
	 * @return string
	 */
	public function render()
	{
		if(Conferences::getActiveConferencesCount() == 0)
		{
			$view = new AllClosed($this->getRouter());
			return $view->render();
		}
		else if(Conferences::getActiveConferencesCount() == 1)
		{
			$activeConferences = Conferences::getActiveConferences();
			$activeConferenceSlug = $activeConferences[0]->getSlug();
			$this->setRedirectHeader($activeConferenceSlug);
			return '';
		}
		else
		{
			$view = new AllConferences($this->getRouter());
			return $view->render();
		}
	}
}
