<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Model\Conferences;
use C3VOC\StreamingWebsite\Model\Upcoming;

class AllClosed extends View
{
	/**
	 * @return string
	 */
	public function render()
	{
		$upcoming = new Upcoming();
		$events = $upcoming->getNextEvents();

		$tpl = $this->createPageTemplate();
		return $tpl->render(array(
			'page' => 'allclosed',
			'title' => 'See you soon … somewhere else!',

			'next' => @$events[0],
			'events' => $events,
			'last' => Conferences::getLastConference(),
		));
	}
}
