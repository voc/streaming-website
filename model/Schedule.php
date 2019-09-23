<?php

class Schedule
{
	private $conference;

	public function __construct($conference)
	{
		$this->conference = $conference;
	}

	public function getConference() {
		return $this->conference;
	}

	public function isEnabled() {
		return $this->getConference()->has('SCHEDULE');
	}

	private function isRoomFiltered($room)
	{
		if(!$this->getConference()->has('SCHEDULE.ROOMFILTER'))
			return false;

		$rooms = $this->getConference()->get('SCHEDULE.ROOMFILTER');
		return !in_array($room, $rooms);
	}

	public function getSimulationOffset() {
		return $this->getConference()->get('SCHEDULE.SIMULATE_OFFSET', 0);
	}

	public function getScale() {
		return floatval($this->getConference()->get('SCHEDULE.SCALE', 7));
	}

	public function isRoomMapped($scheduleRoom) {
		$mapping = $this->getScheduleToRoomSlugMapping();
		return isset( $mapping[$scheduleRoom] );
	}

	public function isOptout($event) {
		if (isset($event->recording)) {
			return $event->recording->optout == 'true';
		}
		return false;
	}

	public function getMappedRoom($scheduleRoom) {
		$mapping = $this->getScheduleToRoomSlugMapping();
		return $this->getConference()->getRoomIfExists( @$mapping[$scheduleRoom] );
	}

	public function getScheduleDisplayTime($basetime = null)
	{
		if(is_null($basetime)) {
			$basetime = time();
		}

		return $basetime + $this->getSimulationOffset();
	}

	private function fetchSchedule()
	{
		$schedule = @file_get_contents($this->getScheduleCache());

		if(!$schedule)
			return null;

		return simplexml_load_string($schedule);
	}

	public function getSchedule()
	{
		// download schedule-xml
		$schedule = $this->fetchSchedule();

		// not failing gracefully here will result in a broken page in case
		// no schedule is present
		if(!$schedule)
			return [];

		$program = array();
		$rooms = array();

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
				$roomName = (string)$room['name'];
				if($this->isRoomFiltered($roomName))
					continue;
				
				if(!in_array($roomName, $rooms))
					$rooms[] = $roomName;

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


		$daysSorted = [];
		foreach($schedule->day as $day)
		{
			$daysSorted[] = $day;
		}

		usort($daysSorted, function($a, $b) {
			return (int)$a['start'] - (int)$b['start'];
		});

		$dayidx = 0;
		foreach($daysSorted as $day)
		{
			$dayidx++;
			$daystart = (int)$day['start'];
			$dayend = (int)$day['end'];

			$roomidx = 0;
			foreach($rooms as $roomName)
			{
				$roomidx++;
				$laststart = false;
				$lastend = false;

				if($this->isRoomFiltered($roomName))
					continue;

				$result = $day->xpath("room[@name='".$roomName."']");
				if(!$result) {
					// this room has no events on this day -> add long gap
					$program[$roomName][] = array(
						'special' => 'gap',

						'fstart' => date('c', $daystart),
						'fend' => date('c', $dayend),

						'start' => $daystart,
						'end' => $dayend,
						'duration' => $dayend - $daystart,
					);
					$program[$roomName][] = array(
						'special' => 'daychange',
						'title' => 'Daychange from Day '.$dayidx.' to '.($dayidx+1),

						'start' => $dayend,
						'end' => (int)$schedule->day[$dayidx]['start'],
						'duration' => 60*60,
					);
					continue;
				}
				$room = $result[0];

				$eventsSorted = [];
				foreach($room->event as $event)
				{
					$eventsSorted[] = $event;
				}

				usort($eventsSorted, function($a, $b) {
					$a_start = (string)$a->date;
					$b_start = (string)$b->date;

					return strcmp($a_start, $b_start);
				});

				foreach($eventsSorted as $event)
				{
					$start = strtotime((string)$event->date);
					$duration = $this->strToDuration((string)$event->duration);
					$end = $start + $duration;

					// skip duplicate events in fahrplan source
					if ( $laststart == $start )
						continue;

					if($lastend && $lastend < $start)
					{
						// synthesize pause event
						$pauseduration = $start - $lastend;
						$program[$roomName][] = array(
							'special' => 'pause',
							'title' => round($pauseduration / 60).' minutes pause',

							'fstart' => date('c', $lastend),
							'fend' => date('c', $start),

							'start' => $lastend,
							'end' => $start,
							'duration' => $pauseduration,
							'room_known' => $this->isRoomMapped($roomName),
						);
					}
					else if(!$lastend && $daystart < $start)
					{
						$program[$roomName][] = array(
							'special' => 'gap',

							'fstart' => date('c', $daystart),
							'fend' => date('c', $start),

							'start' => $daystart,
							'end' => $start,
							'duration' => $start - $daystart,
							'room_known' => $this->isRoomMapped($roomName),
						);
					}

					$personnames = array();
					if(isset($event->persons)) foreach($event->persons->person as $person)
						$personnames[] = (string)$person;

					$program[$roomName][] = array(
						'title' => (string)$event->title,
						'speaker' => implode(', ', $personnames),

						'fstart' => date('c', $start),
						'fend' => date('c', $end),

						'start' => $start,
						'end' => $end,
						'duration' => $duration,
						'room_known' => $this->isRoomMapped($roomName),
						'optout' => $this->isOptout($event),
					);

					$laststart = $start;
					$lastend = $end;
				}

				// synthesize daychange event
				if(!$lastend) $lastend = $daystart;
				if($lastend < $dayend)
				{
					$program[$roomName][] = array(
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
					$program[$roomName][] = array(
						'special' => 'daychange',
						'title' => 'Daychange from Day '.$dayidx.' to '.($dayidx+1),

						'start' => $dayend,
						'end' => (int)$schedule->day[$dayidx]['start'],
						'duration' => 60*60,
					);
				}
			}
		}


		$mapping = $this->getScheduleToRoomSlugMapping();
		if($this->getConference()->has('SCHEDULE.ROOMFILTER'))
		{
			// sort by roomfilter
			$roomfilter = $this->getConference()->get('SCHEDULE.ROOMFILTER');

			// map roomfilter-rooms to room-slugs
			$roomfilter = array_map(function($e) use ($mapping) {
				if(isset($mapping[$e]))
					return $mapping[$e];

				return $e;
			}, $roomfilter);

			// sort according to roomtilter ordering
			uksort($program, function($a, $b) use ($roomfilter) {
				return array_search($a, $roomfilter) - array_search($b, $roomfilter);
			});
		}

		return $program;
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

	public function getScheduleUrl()
	{
		return $this->getConference()->get('SCHEDULE.URL');
	}

	public function getScheduleCache()
	{
		return sprintf('/tmp/schedule-cache-%s.xml', $this->getConference()->getSlug());
	}

	public function getScheduleToRoomSlugMapping()
	{
		$mapping = array();
		foreach($this->getConference()->get('ROOMS') as $slug => $room)
		{
			if(isset($room['SCHEDULE_NAME']))
				$mapping[ $room['SCHEDULE_NAME'] ] = $slug;
			else if(isset($room['DISPLAY']))
				$mapping[ $room['DISPLAY'] ] = $slug;
			else
				$mapping[ $slug ] = $slug;
		}

		return $mapping;
	}
}
