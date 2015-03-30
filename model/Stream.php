<?php

class Stream
{
	public function __construct(Room $room, $selection, $language)
	{
		$this->room = $room;
		$this->selection = $selection;
		$this->language = $language;
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function getSelection()
	{
		return $this->selection;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function isTranslated()
	{
		return $this->getLanguage() == 'translated';
	}

	public function getVideoSize()
	{
		switch($this->getSelection())
		{
			case 'sd':
			case 'slides':
				return array(1024, 576);

			case 'hd':
				return array(1920, 1080);

			default:
				return null;
		}
	}

	public function getVideoWidth()
	{
		$sz = $this->getVideoSize();
		return $sz[0];
	}

	public function getVideoHeight()
	{
		$sz = $this->getVideoSize();
		return $sz[1];
	}

	public function getTab()
	{
		switch($this->getSelection())
		{
			case 'sd':
			case 'hd':
				return 'video';

			default:
				return $this->getSelection();
		}
	}

	public function getPlayerType()
	{
		return $this->getTab();
	}

	public function getDisplay()
	{
		$display = $this->getRoom()->getDisplay().' ';
		switch($this->getSelection())
		{
			case 'hd':
				$display .= 'FullHD Video';
				break;

			case 'sd':
				$display .= 'SD Video';
				break;

			default:
				$display .= ucfirst($this->getSelection());
				break;
		}

		if($this->isTranslated())
			$display .= ' (Translation)';

		return $display;
	}

	public function getVideoUrl($proto)
	{
		switch($proto)
		{
			case 'webm':
				return 'http://cdn.c3voc.de/'.rawurlencode($this->getRoom()->getStream()).'_'.rawurlencode($this->getLanguage()).'_'.rawurlencode($this->getSelection()).'.webm';

			case 'hls':
				return 'http://cdn.c3voc.de/hls/'.rawurlencode($this->getRoom()->getStream()).'_'.rawurlencode($this->getLanguage()).'_'.rawurlencode($this->getSelection()).'.m3u8';

			default:
				return null;
		}
	}
	public static function getVideoProtos()
	{
		return array(
			'webm' => 'WebM',
			'hls' => 'HLS',
		);
	}

	public function getSlidesUrl($proto)
	{
		return $this->getVideoUrl($proto);
	}
	public static function getSlidesProtos()
	{
		return Stream::getVideoProtos();
	}


	public function getAudioUrl($proto)
	{
		switch($proto)
		{
			case 'mp3':
				return 'http://cdn.c3voc.de/'.rawurlencode($this->getRoom()->getStream()).'_'.rawurlencode($this->getLanguage()).'.mp3';

			case 'opus':
				return 'http://cdn.c3voc.de/'.rawurlencode($this->getRoom()->getStream()).'_'.rawurlencode($this->getLanguage()).'.opus';

			default:
				return null;
		}
	}
	public static function getAudioProtos()
	{
		return array(
			'mp3' => 'MP3',
			'opus' => 'Opus',
		);
	}

	public function getMusicUrl($proto)
	{
		switch($proto)
		{
			case 'mp3':
				return 'http://cdn.c3voc.de/'.rawurlencode($this->getRoom()->getStream()).'.mp3';

			case 'opus':
				return 'http://cdn.c3voc.de/'.rawurlencode($this->getRoom()->getStream()).'.opus';

			default:
				return null;
		}
	}
	public static function getMusicProtos()
	{
		return array(
			'mp3' => 'MP3',
			'opus' => 'Opus',
		);
	}
}
