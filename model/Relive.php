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
		if($talks_by_id = $this->getCached())
			return $talks_by_id;

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

		return $this->doCache($talks_by_id);
	}

	public function getTalk($id)
	{
		$talks = $this->getTalks();
		if(!isset($talks[$id]))
			throw new NotFoundException('Relive-Talk id '.$id);

		return $talks[$id];
	}

	private function isCacheEnabled()
	{
		return $this->has('CONFERENCE.RELIVE_JSON_CACHE') && function_exists('apc_fetch') && function_exists('apc_store');
	}

	private function getCacheDuration()
	{
		return $this->get('CONFERENCE.RELIVE_JSON_CACHE', 60*10 /* 10 minutes */);
	}

	private $localCache = null;
	private function getCached()
	{
		if($this->localCache)
			return $this->localCache;

		if(!$this->isCacheEnabled())
			return null;

		return apc_fetch($this->getCacheKey());
	}

	private function doCache($value)
	{
		$this->localCache = $value;

		if(!$this->isCacheEnabled())
			return $value;

		apc_store($this->getCacheKey(), $value, $this->getCacheDuration());
		return $value;
	}

	private function getCacheKey()
	{
		return 'RELIVE.'.$this->getJsonUrl();
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
