<?php

class Subtitles extends ModelBase
{
	public function isEnabled() {
		return $this->has('SUBTITLES');
	}

	public function getEnabledRooms($slug) {
		$rooms = [];
		foreach(Room::rooms() as $room)
		{
			if($room->hasSubtitles())
				$rooms[] = $room;
		}

		return $rooms;
	}

	public function getPrimusURL() {
		return $this->get('SUBTITLES.PRIMUS_URL');
	}
	public function getFrontendURL() {
		return $this->get('SUBTITLES.FRONTEND_URL');
	}
}
