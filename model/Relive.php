<?php

class Relive
{
	private $conference;

	public function __construct($conference)
	{
		$this->conference = $conference;
	}

	public function getConference() {
		return $this->conference;
	}

	public function isEnabled()
	{
		// having CONFERENCE.RELIVE is not enough!
		return $this->getConference()->has('CONFERENCE.RELIVE_JSON');
	}

	public function getJsonUrl()
	{
		return $this->getConference()->get('CONFERENCE.RELIVE_JSON');
	}

	public function getPreRecOffset()
	{
		return $this->getConference()->get('CONFERENCE.RELIVE_SKIP_PREREC_OFFSET') ?: 900;
	}

	public function getJsonCache()
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return sprintf('C:\tmp\relive-cache-%s.json', $this->getConference()->getSlug());
		} else {
			return sprintf('/tmp/relive-cache-%s.json', $this->getConference()->getSlug());
		}
	}

	public function getTalks()
	{
		if(!file_exists($this->getJsonCache()))
			return array();

		$talks = file_get_contents($this->getJsonCache());
		$talks = (array)json_decode($talks, true);

		$mapping = $this->getScheduleToRoomMapping();

		usort($talks, function($a, $b) {
			// first, make sure that live talks are always on top
			if($a['status'] == 'live' && $b['status'] != 'live') {
				return -1;
			}
			else if($a['status'] != 'live' && $b['status'] == 'live') {
				return 1;
			}
			else if($a['status'] == 'live' && $b['status'] == 'live') {
				// sort live talks by room
				return strcmp($a['room'], $b['room']);
			}

			// all other talks get sorted by their start time
			// sorting the most recent talks to the top
			$delta = $b['start'] - $a['start'];

			// sort by room in case of a collision
			if($delta == 0)
				return strcmp($a['room'], $b['room']);
			else
				return $delta;
		});

		$talks_by_id = array();
		foreach ($talks as $talk)
		{
			if($talk['status'] == 'not_running')
				continue;

			if($talk['status'] == 'released') {
				$talk['url'] = $talk['release_url'];
			}
			else {
				$talk['url'] = joinpath([
					$this->getConference()->getSlug(),
					'relive',
					rawurlencode($talk['id']),
				]);
			}

			if(isset($mapping[$talk['room']]))
			{
				$room = $mapping[$talk['room']];
				$talk['room'] = $room->getDisplay();
				$talk['roomlink'] = $room->getLink();
			}

			$talks_by_id[$talk['id']] = $talk;
		}

		return $talks_by_id;
	}

	public function getTalk($id)
	{
		$talks = $this->getTalks();
		if(!isset($talks[$id]))
			throw new NotFoundException('Relive-Talk id '.$id);

		return $talks[$id];
	}

	private function getScheduleToRoomMapping()
	{
		$schedule = $this->getConference()->getSchedule();
		$mapping = array();

		foreach($schedule->getScheduleToRoomSlugMapping() as $schedule => $slug)
		{
			try {
				$mapping[$schedule] = $this->getConference()->getRoom($slug);
			}
			catch(NotFoundException $e)
			{
				//
			}
		}

		return $mapping;
	}

}
