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
			foreach($day->room as $room)
			{
				$roomidx++;
				$lastend = false;

				$name = trim((string)$room['name']);
				if($this->isRoomFiltered($name))
					continue;

				$room_known = isset($mapping[$name]);

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
							'room_known' => $room_known,
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
							'room_known' => $room_known,
						);
					}

				$personnames = array();
				if(isset($event->persons)) foreach($event->persons->person as $person)
					$personnames[] = (string)$person;

				$program[$name][] = array(
						'title' => (string)$event->title,
						'speaker' => implode(', ', $personnames),

						'fstart' => date('c', $start),
						'fend' => date('c', $end),

						'start' => $start,
						'end' => $end,
						'duration' => $duration,
						'room_known' => $room_known,
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
		}

		return $mapping;
	}
}
