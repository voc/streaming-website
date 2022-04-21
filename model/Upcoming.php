<?php

class Upcoming
{
	private static $events;

	public static function getNextEvents()
	{
		try {
			if (!isset(self::$events)) {
				$events = file_get_contents('configs/upcoming.json');
				$events = json_decode($events, true);

				self::$events = array_values($events['voc_events']);
			}
			return self::$events;
		}
		catch(ErrorException $e)
		{
			return array();
		}
	}
}
