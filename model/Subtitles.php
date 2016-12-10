<?php

class Subtitles
{
	private $conference;

	public function __construct(Conference $conference)
	{
		$this->conference = $conference;
	}

	public function getConference() {
		return $this->conference;
	}

	public function isEnabled() {
		return $this->getConference()->has('SUBTITLES');
	}

	public function getEnabledRooms($slug) {
		$rooms = [];
		foreach($this->getConference()->getOverview()->getRooms() as $room)
		{
			if($room->hasSubtitles())
				$rooms[] = $room;
		}

		return $rooms;
	}

	public function getPrimusURL() {
		return $this->getConference()->get('SUBTITLES.PRIMUS_URL');
	}
	public function getFrontendURL() {
		return $this->getConference()->get('SUBTITLES.FRONTEND_URL');
	}
}
