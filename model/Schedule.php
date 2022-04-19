<?php

class Schedule
{
	private $conference;
	private $program;

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

	public function getRoomSchedule($roomName, $roomGuid) {

		// build program, if not realy set
		if (!isset($this->program)) {
			$this->getSchedule();
		}

		return $this->program[$roomName];
	}

	public function getSchedule()
	{
		// reusue already computed schedule, if set.
		if (isset($this->program)) {
			return $this->program;
		}

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
			$daystart = new DateTimeImmutable('+100 year');
			$dayend = new DateTimeImmutable('-100 year');

			foreach($day->room as $room)
			{
				$roomName = (string)$room['name'];
				if($this->isRoomFiltered($roomName))
					continue;

				if(!in_array($roomName, $rooms))
					$rooms[] = $roomName;

				foreach($room->event as $event)
				{
					$start = new DateTimeImmutable((string)$event->date);
					$interval = $this->strToInterval((string)$event->duration);
					$end = $start->add($interval);

					$daystart = $start < $daystart ? $start : $daystart;
					$dayend = $end > $dayend ? $end : $dayend;
				}
			}

			// stringify again to store in simplexml
			$day['start'] = $daystart->format('c');
			$day['end'] = $dayend->format('c');
		}


		$daysSorted = [];
		foreach($schedule->day as $day)
		{
			$daysSorted[] = $day;
		}

		usort($daysSorted, function($a, $b): int {
			return strcmp($a['start'], $b['start']);
		});

		$dayidx = 0;
		foreach($daysSorted as $day)
		{
			$dayidx++;
			$daystart = new DateTimeImmutable($day['start']);
			$dayend = new DateTimeImmutable($day['end']);

			$roomidx = 0;
			foreach($rooms as $roomName)
			{
				$roomidx++;
				$laststart = NULL;
				$lastend = NULL;

				if($this->isRoomFiltered($roomName))
					continue;

				$result = $day->xpath("room[@name='".$roomName."']");
				// if this room has no events on this day -> add long gap
				if(!$result) {
					$nextday = $schedule->day[$dayidx];
					
					// but not if it is the last day
					if(!$nextday) {
						continue;
					}

					$gap = $this->makeEvent($daystart, $dayend);
					$gap['special'] = 'gap';
					$program[$roomName][] = $gap;

					$end = new DateTimeImmutable($nextday['start']);
					$daychange = $this->makeEvent($dayend, $end);
					$daychange['special'] = 'daychange';
					$daychange['title'] = 'Daychange from Day '.$dayidx.' to '.($dayidx+1);
					$daychange['duration'] = 3600;
					$program[$roomName][] = $daychange;
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
					$start = new DateTimeImmutable((string)$event->date);
					$interval = $this->strToInterval((string)$event->duration);
					$end = $start->add($interval);

					// skip duplicate events in fahrplan source
					if ( $laststart == $start )
					continue;

					if($lastend && $lastend < $start)
					{
						// pause between talks
						$pause = $this->makeEvent($lastend, $start);
						$pause['special'] = 'pause';
						$pause['title'] = round($pause['duration'] / 60).' minutes pause';
						$pause['room_known'] = $this->isRoomMapped($roomName);
						$program[$roomName][] = $pause;
					}
					else if(!$lastend && $daystart < $start)
					{
						// gap before first talk
						$gap = $this->makeEvent($daystart, $start);
						$gap['special'] = 'gap';
						$gap['room_known'] = $this->isRoomMapped($roomName);
						$program[$roomName][] = $gap;
					}

					$personnames = array();
					if(isset($event->persons)) foreach($event->persons->person as $person)
						$personnames[] = (string)$person;

					// normal talk
					$talk = $this->makeEvent($start, $end);
					$talk['title'] = (string)$event->title;
					$talk['speaker'] = implode(', ', $personnames);
					$talk['room_known'] = $this->isRoomMapped($roomName);
					$talk['optout'] = $this->isOptout($event);
					$program[$roomName][] = $talk;

					$laststart = $start;
					$lastend = $end;
				}

				if(!$lastend) $lastend = $daystart;
				if($lastend < $dayend)
				{
					// gap after last talk
					$gap = $this->makeEvent($lastend, $dayend);
					$gap['special'] = 'gap';
					$program[$roomName][] = $gap;
				}

				if($dayidx < count($schedule->day))
				{
					// daychange
					$end = new DateTimeImmutable($schedule->day[$dayidx]['start']);
					$daychange = $this->makeEvent($dayend, $end);
					$daychange['special'] = 'daychange';
					$daychange['title'] = 'Daychange from Day '.$dayidx.' to '.($dayidx+1);
					$daychange['duration'] = 3600;
					$program[$roomName][] = $daychange;
				}
			}
		}

		$mapping = $this->getScheduleToRoomSlugMapping();
		if($this->getConference()->has('SCHEDULE.ROOMFILTER'))
		{
			// determine roomfilter
			$roomfilter = $this->getConference()->get('SCHEDULE.ROOMFILTER');

			// map roomfilter-rooms to room-slugs
			$roomfilter = array_map(function($e) use ($mapping) {
				if(isset($mapping[$e]))
					return $mapping[$e];

				return $e;
			}, $roomfilter);

			// sort according to roomfilter ordering
			uksort($program, function($a, $b) use ($roomfilter) {
				return array_search($a, $roomfilter) - array_search($b, $roomfilter);
			});
		}
		$this->program = $program;

		return $this->program;
	}

	private function makeEvent(DateTimeImmutable $from, DateTimeImmutable $to): array {
		return array(
			'fstart' => $from->format('c'),
			'fend' => $to->format('c'),
			'tstart' => $from->format('H:i'),
			'tend' => $to->format('H:i'),

			'start' => $from->getTimestamp(),
			'end' => $to->getTimestamp(),
			'offset' => $from->getOffset(),
			'duration' => $to->getTimestamp() - $from->getTimestamp(),
		);
	}

	private function intervalToDuration(DateInterval $interval): int {
		$one = new DateTimeImmutable();
		$two = $one->add($interval);
		return $two->getTimestamp() - $one->getTimestamp();
	}

	private function strToInterval(string $str): DateInterval
	{
		$parts = explode(':', $str);
		return new DateInterval('PT'.$parts[0].'H'.$parts[1].'M');
	}


	public function getDurationSum()
	{
		$sum = 0;
		$schedule = $this->getSchedule();
		if ($schedule) {
			foreach(reset($schedule) as $event) {
				$sum += $event['duration'];
			}
		}
		return $sum;
	}


	public function getScheduleUrl()
	{
		return $this->getConference()->get('SCHEDULE.URL');
	}


	public function getScheduleCache()
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return sprintf('C:\tmp\schedule-cache-%s.xml', $this->getConference()->getSlug());
		} else {
			return sprintf('/tmp/schedule-cache-%s.xml', $this->getConference()->getSlug());
		}
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
