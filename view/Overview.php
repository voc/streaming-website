<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;
use C3VOC\StreamingWebsite\Model\Conference;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Overview
{
	public function action($conference) {
		return 'Lala: '.$conference;
	}

	/**
	 * @param Conference $conference
	 * @return array
	 */
	private function getUpcomingTalks(Conference $conference)
	{
		$schedule = $conference->getSchedule();
		$talksPerRoom = $schedule->getSchedule();
		$now = time() + $schedule->getSimulationOffset();

		$upcomingTalksPerRoom = array_map(function ($talks) use ($now) {
			return [
				'current' => array_filter_last($talks, function ($talk) use ($now) {
					return $talk['start'] < $now && $talk['end'] > $now;
				}),
				'next' => array_filter_first($talks, function ($talk) use ($now) {
					return !isset($talk['special']) && $talk['start'] > $now;
				}),
			];
		}, $talksPerRoom);

		return $upcomingTalksPerRoom;
	}
}
