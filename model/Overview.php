<?php

require_once('model/Room.php');

class Overview
{
	public function getGroups() {
		$groups = array();

		foreach(get('OVERVIEW.GROUPS') as $group => $rooms)
		{
			foreach($rooms as $room)
			{
				try {
					$groups[$group][] = Room::get($room);
				}
				catch(NotFountException $e)
				{
					// just ignore unknown rooms
					continue;
				}
			}
		}

		return $groups;
	}

	public function getReleasesUrl() {
		return get('OVERVIEW.RELEASES');
	}

	public function getReliveUrl() {
		if(has('OVERVIEW.RELIVE'))
			return get('OVERVIEW.RELIVE');

		elseif(has('OVERVIEW.RELIVE_JSON'))
			return 'relive/';

		else
			return null;
	}



	public function hasRelive() {
		return has('OVERVIEW.RELIVE') || has('OVERVIEW.RELIVE_JSON');
	}

	public function hasReleases() {
		return has('OVERVIEW.RELEASES');
	}
}
