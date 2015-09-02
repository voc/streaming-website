<?php

class Relive extends ModelBase
{
	public function isEnabled()
	{
		// having CONFERENCE.RELIVE is not enough!
		return $this->has('CONFERENCE.RELIVE_JSON');
	}

	public function getJsonUrl()
	{
		return $this->get('CONFERENCE.RELIVE_JSON');
	}

	public function getTalks()
	{
		$talks = file_get_contents($this->getJsonUrl());
		$talks = (array)json_decode($talks, true);

		$mapping = $this->getScheduleToRoomMapping();

		usort($talks, function($a, $b) {
			$sort = array('live', 'recorded', 'released');
			return array_search($a['status'], $sort) > array_search($b['status'], $sort);
		});

		$talks_by_id = array();
		foreach ($talks as $talk)
		{
			if($talk['status'] == 'not_running')
				continue;

			if($talk['status'] == 'released')
				$talk['url'] = $talk['release_url'];
			else
				$talk['url'] = 'relive/'.rawurlencode($talk['id']).'/';

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
		$schedule = new Schedule();
		$mapping = array();

		foreach($schedule->getScheduleToRoomSlugMapping() as $schedule => $slug)
		{
			try {
				$mapping[$schedule] = new Room($slug);
			}
			catch(NotFoundException $e)
			{
				//
			}
		}

		return $mapping;
	}

}
