<?php

class Schedule extends ModelBase
{
	public function getSimulationOffset() {
		return $this->get('SCHEDULE.SIMULATE_OFFSET', 0);
	}

	private function strtoduration($str)
	{
		$parts = explode(':', $str);
		return ((int)$parts[0] * 60 + (int)$parts[1]) * 60;
	}

	function program()
	{
		if(!has('SCHEDULE'))
			return;

		if(has('SCHEDULE.CACHE') && function_exists('apc_fetch'))
		{
			$program = apc_fetch('SCHEDULE.CACHE');
			if($program) return $program;
		}


		$program = array();
		$opts = array(
			'http' => array(
				'timeout' => 2,
				'user_agent' => 'C3Voc Universal Streaming-Website Backend @ '.$_SERVER['HTTP_HOST'],
			)
		);
		$context  = stream_context_create($opts);
		$schedule = file_get_contents(get('SCHEDULE.URL'), false, $context);

		// failed, give up
		if(!$schedule)
			return array();

		$schedule = simplexml_load_string($schedule);

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
				foreach($room->event as $event)
				{
					$start = strtotime((string)$event->date);
					$duration = strtoduration((string)$event->duration);
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
				if(isset($GLOBALS['CONFIG']['FAHRPLAN_ROOM_MAPPING'][$name]))
					$name = $GLOBALS['CONFIG']['FAHRPLAN_ROOM_MAPPING'][$name];

				foreach($room->event as $event)
				{
					$start = strtotime((string)$event->date);
					$duration = strtoduration((string)$event->duration);
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

		if(has('SCHEDULE.CACHE') && function_exists('apc_store'))
		{
			apc_store(
				'SCHEDULE.CACHE',
				$program,
				get('SCHEDULE.CACHE')
			);
		}

		return $program;
	}
}
