<?php

class Overview extends ModelBase
{
	public function getGroups() {
		$groups = array();

		foreach($this->get('OVERVIEW.GROUPS') as $group => $rooms)
		{
			foreach($rooms as $room)
			{
				try {
					$groups[$group][] = new Room($room);
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
}
