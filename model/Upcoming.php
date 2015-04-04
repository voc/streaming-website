<?php

class Upcoming
{
	public function getNextEvent()
	{
		try {
			$events = file_get_contents('https://c3voc.de/eventkalender/events.json?filter=upcoming');
			$events = json_decode($events, true);
			$names = array_keys($events['voc_events']);

			return $events['voc_events'][$names[0]];
		}
		catch(ErrorException $e)
		{
			return null;
		}
	}
}
