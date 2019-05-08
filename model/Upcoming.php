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

	/*
		Try to find the next upcoming event, which does not match current event.
	*/
	public function getNextEvent($currentEvent = "")
	{
		$nextEvents = getNextEvents();
		foreach($nextEvents as $event) {
			similar_text($event["name"], $currentEvent, $percentMatch);

			if($percentMatch < 50) {
				return $event;
			}
		}

		return @$nextEvents[0];
	}
}
