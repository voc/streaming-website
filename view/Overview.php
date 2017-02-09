<?php

namespace C3VOC\StreamingWebsite\View;

class Overview extends ConferenceView
{
	public function render()
	{
		$tpl = $this->createPageTemplate();
		return $tpl->render([
			'page' => 'overview',
			'title' => 'Live-Streams',

			'overview' => $this->getConference()->getOverview(),

			'upcomingTalksPerRoom' => $this->getUpcomingTalks(),
		]);
	}

	/**
	 * @return array
	 */
	private function getUpcomingTalks()
	{
		$schedule = $this->getConference()->getSchedule();

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
