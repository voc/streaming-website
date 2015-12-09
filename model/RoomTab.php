<?php

class RoomTab
{
	public function __construct(Room $room, $tab)
	{
		$this->room = $room;
		$this->tab = $tab;
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function getTab()
	{
		return $this->tab;
	}

	public function getLink()
	{
		$tabs = $this->getRoom()->getTabNames();
		if($tabs[0] == $this->getTab())
			return rawurlencode($this->getRoom()->getSlug()).'/';

		return rawurlencode($this->getRoom()->getSlug()).'/'.rawurlencode($this->getTab()).'/';
	}

	public function getDisplay()
	{
		$tab = $this->getTab();
		switch($tab)
		{
			case 'music':
				return 'Radio';

			default:
				return ucfirst($tab);
		}
	}
}
