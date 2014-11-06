<?php

function program()
{
	$cacheidx = __FILE__.':'.__FUNCTION__.':program';
	if(function_exists('apc_fetch') && $program = apc_fetch($cacheidx))
		return $program;

	$program = array();
	$schedule = simplexml_load_file($GLOBALS['CONFIG']['SCHEDULE']);

	$dayidx = 0;
	foreach($schedule->day as $day)
	{
		$dayidx++;
		$daystart = strtotime((string)$day['start']);
		$dayend = strtotime((string)$day['end']);

		$roomidx = 0;
		foreach($day->room as $room)
		{
			$roomidx++;
			$name = (string)$room['name'];
			$lastend = false;

			foreach ($room->event as $event)
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

				$program[$name][] = array(
					'title' => (string)$event->title,

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
					'end' => strtotime((string)$schedule->day[$dayidx+1]['start']),
					'duration' => 60*60,
				);
			}
		}
	}

	if(function_exists('apc_store'))
		apc_store($cacheidx, $program, $GLOBALS['CONFIG']['SCHEDULE_CACHE_TTL']);

	return $program;
}
