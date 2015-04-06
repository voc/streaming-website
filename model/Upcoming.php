<?php

class Upcoming
{
	public function getNextEvents()
	{
		try {
			$events = file_get_contents('https://c3voc.de/eventkalender/events.json?filter=upcoming');
			$events = json_decode($events, true);

			return array_values($events['voc_events']);
		}
		catch(ErrorException $e)
		{
			return null;
		}
	}
}
