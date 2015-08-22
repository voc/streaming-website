<?php

class Upcoming
{
	public function getNextEvents()
	{
		try {
			$events = file_get_contents('configs/upcoming.json');
			$events = json_decode($events, true);

			return array_values($events['voc_events']);
		}
		catch(ErrorException $e)
		{
			return array();
		}
	}
}
