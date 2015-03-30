<?php

class RoomSelection
{
	public function __construct(Room $room, $selection)
	{
		$this->room = $room;
		$this->selection = $selection;
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function getSelection()
	{
		return $this->selection;
	}

	public function getLink()
	{
		$selection = $this->getRoom()->getSelectionNames();
		if($selection[0] == $this->getSelection())
			return rawurlencode($this->getRoom()->getSlug()).'/';

		return rawurlencode($this->getRoom()->getSlug()).'/'.rawurlencode($this->getSelection()).'/';
	}

	public function getTranslatedLink()
	{
		return $this->getLink().'translated/';
	}

	public function getDisplay()
	{
		switch($this->getSelection())
		{
			case 'sd':
			case 'hd':
				return strtoupper($this->getSelection());

			default:
				return ucfirst($this->getSelection());
		}
	}

	public function getTech()
	{
		return $this->getSelection().'-tech';
	}
}
