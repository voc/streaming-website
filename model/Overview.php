<?php

namespace C3VOC\StreamingWebsite\Model;

use C3VOC\StreamingWebsite\Lib\NotFoundException;

class Overview
{
	public function __construct(Conference $conference)
	{
		$this->conference = $conference;
	}

	public function getConference() {
		return $this->conference;
	}

	public function getGroups() {
		$groups = array();

		foreach($this->getConference()->get('OVERVIEW.GROUPS') as $group => $rooms)
		{
			foreach($rooms as $room)
			{
				try {
					$groups[$group][] = $this->getConference()->getRoom($room);
				}
				catch(NotFoundException $e)
				{
					// just ignore unknown rooms
					continue;
				}
			}
		}

		return $groups;
	}
}
