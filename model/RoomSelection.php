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
		$path = [$this->getRoom()->getConference()->getSlug(), $this->getRoom()->getSlug()];

		$selection = $this->getRoom()->getSelectionNames();
		if($selection[0] != $this->getSelection())
			$path[] = $this->getSelection();

		return joinpath($path).url_params();
	}

	public function getTranslatedLink()
	{
		return joinpath([$this->getLink(), 'translated']);
	}

	public function getDisplay()
	{
		switch($this->getSelection())
		{
			case 'sd':
			case 'hd':
				return strtoupper($this->getSelection());

			case 'music':
				return 'Radio';

			default:
				return ucfirst($this->getSelection());
		}
	}

	public function getTech()
	{
		return $this->getSelection().'-tech';
	}
}
