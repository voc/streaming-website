<?php

class Schedule extends ModelBase
{
	public function isEnabled() {
		return $this->has('SCHEDULE');
	}

	private function isRoomFiltered($room)
	{
		if(!$this->has('SCHEDULE.ROOMFILTER'))
			return false;

		$rooms = $this->get('SCHEDULE.ROOMFILTER');
		return !in_array($room, $rooms);
	}

	public function getSimulationOffset() {
		return $this->get('SCHEDULE.SIMULATE_OFFSET', 0);
	}

	public function getScale() {
		return floatval($this->get('SCHEDULE.SCALE', 7));
	}

	private function fetchSchedule()
	{
		$opts = array(
			'http' => array(
				'timeout' => 2,
				'user_agent' => 'C3Voc Universal Streaming-Website Backend @ '.$_SERVER['HTTP_HOST'],
			)
		);
		$context  = stream_context_create($opts);
		$schedule = file_get_contents($this->getScheduleUrl(), false, $context);

		if(!$schedule)
			throw new ScheduleException("Error Downloading Schedule from ".$this->getScheduleUrl());

		return simplexml_load_string($schedule);
	}

	public function getSchedule()
	{
		if($schedule = $this->getCached())
			return $schedule;

		// download schedule-xml
		try
		{
			$schedule = $this->fetchSchedule();
		}
		catch(Exception $e)
		{
			return array();
		}

		$mapping = $this->getScheduleToRoomSlugMapping();
		$program = array();

		// re-calculate day-ends
		// some schedules have long gaps before the first talk or talks that expand beyond the dayend
		// (fiffkon, i look at you)
		// so to be on the safer side we calculate our own daystart/end here
		foreach($schedule->day as $day)
		{
			$daystart = PHP_INT_MAX;
			$dayend = 0;

			foreach($day->room as $room)
			{
				$name = (string)$room['name'];
				if($this->isRoomFiltered($name))
					continue;

				foreach($room->event as $event)
				{
					$start = strtotime((string)$event->date);
					$duration = $this->strToDuration((string)$event->duration);
					$end = $start + $duration;

					$daystart = min($daystart, $start);
					$dayend = max($dayend, $end);
				}
			}

			$day['start'] = $daystart;
			$day['end'] = $dayend;
		}

		$dayidx = 0;
		foreach($schedule->day as $day)
		{
			$dayidx++;
			$daystart = (int)$day['start'];
			$dayend = (int)$day['end'];

			$roomidx = 0;
			foreach($day->room as $room)
			{
				$roomidx++;
				$lastend = false;

				$name = (string)$room['name'];
				if($this->isRoomFiltered($name))
					continue;

				if(isset($mapping[$name]))
					$name = $mapping[$name];

				foreach($room->event as $event)
				{
					$start = strtotime((string)$event->date);
					$duration = $this->strToDuration((string)$event->duration);
					$end = $start + $duration;

					if($lastend && $lastend < $start)
					{
						// synthesize pause event
						$pauseduration = $start - $lastend;
						$program[$name][] = array(
							'special' => 'pause',
							'title' => round($pauseduration / 60).' minutes pause',

							'fstart' => date('c', $lastend),
							'fend' => date('c', $start),

							'start' => $lastend,
							'end' => $start,
							'duration' => $pauseduration,
						);
					}
					else if(!$lastend && $daystart < $start)
					{
						$program[$name][] = array(
							'special' => 'gap',

							'fstart' => date('c', $daystart),
							'fend' => date('c', $start),

							'start' => $daystart,
							'end' => $start,
							'duration' => $start - $daystart,
						);
					}

				$personnames = array();
				foreach($event->persons->person as $person)
					$personnames[] = (string)$person;

				$program[$name][] = array(
						'title' => (string)$event->title,
						'speaker' => implode(', ', $personnames),

						'fstart' => date('c', $start),
						'fend' => date('c', $end),

						'start' => $start,
						'end' => $end,
						'duration' => $duration,
					);

					$lastend = $end;
				}

				// synthesize daychange event
				if(!$lastend) $lastend = $daystart;
				if($lastend < $dayend)
				{
					$program[$name][] = array(
						'special' => 'gap',

						'fstart' => date('c', $lastend),
						'fend' => date('c', $dayend),

						'start' => $lastend,
						'end' => $dayend,
						'duration' => $dayend - $lastend,
					);
				}

				if($dayidx < count($schedule->day))
				{
					$program[$name][] = array(
						'special' => 'daychange',
						'title' => 'Daychange from Day '.$dayidx.' to '.($dayidx+1),

						'start' => $dayend,
						'end' => (int)$schedule->day[$dayidx]['start'],
						'duration' => 60*60,
					);
				}
			}
		}

		return $this->doCache($program);
	}


	public function getDurationSum()
	{
		$sum = 0;
		$schedule = $this->getSchedule();
		foreach(reset($schedule) as $event)
			$sum += $event['duration'];

		return $sum;
	}



	private function strToDuration($str)
	{
		$parts = explode(':', $str);
		return ((int)$parts[0] * 60 + (int)$parts[1]) * 60;
	}

	private function getScheduleUrl()
	{
		return $this->get('SCHEDULE.URL');
	}

	private function isCacheEnabled()
	{
		return $this->has('SCHEDULE.CACHE') && function_exists('apc_fetch') && function_exists('apc_store');
	}

	private function getCacheDuration()
	{
		return $this->get('SCHEDULE.CACHE', 60*10 /* 10 minutes */);
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
		return 'SCHEDULE.'.$this->getScheduleUrl();
	}

	public function getScheduleToRoomSlugMapping()
	{
		$mapping = array();
		foreach($this->get('ROOMS') as $slug => $room)
		{
			if(isset($room['SCHEDULE_NAME']))
				$mapping[ $room['SCHEDULE_NAME'] ] = $slug;
		}

		return $mapping;
	}
}
