<?php

class Upcoming
{
	private static $events;

	public static function getNextEvents($filter = null)
	{
		try {
			if (!isset(self::$events)) {
				$events = file_get_contents('configs/upcoming.json');
				$events = json_decode($events, true);

				self::$events = array_values($events['voc_events']);
			}

			if (!is_null($filter) && $filter) {
				return array_values(array_filter(self::$events, function($event) use($filter) {
					return preg_match($filter, $event['slug']);
				}));
			}

			return self::$events;
		}
		catch(ErrorException $e)
		{
			return array();
		}
	}
}
