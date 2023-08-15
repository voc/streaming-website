<?php

class Stream
{
	public function __construct(Room $room, $selection, $language, $translation_label = null)
	{
		$this->room = $room;
		$this->selection = $selection;
		$this->language = $language;
	 	$this->translation_label = (empty($translation_label)) ? $language : $translation_label;
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

	public function getTranslationLabel()
	{
	  return $this->translation_label;
	}

	public function isTranslated()
	{
		return !empty($this->getLanguage()) &&
			$this->getLanguage() !== 'native';
	}

	public function getVideoSize()
	{
		switch($this->getSelection())
		{
			case 'sd':
				return array(1024, 576);

			case 'slides':
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

			case 'music':
				$display .= 'Radio';
				break;

			case 'hls':
				// do not add suffix when we only provide HLS
				if($this->getRoom()->h264Only()) {
					break;
				}
			case 'dash':
				if($this->getRoom()->h264Only()) {
					$display .= 'DASH';
					break;
				}
			default:
				$display .= ucfirst($this->getSelection());
				break;
		}

		if($this->isTranslated())
			$display .= ' ('. $this->getTranslationLabel() .')';

		return $display;
	}

	public function getEmbedUrl()
	{
		return joinpath([
			baseurl(),
			$this->getRoom()->getConference()->getSlug(),
			'embed',
			rawurlencode($this->getRoom()->getSlug()),
			rawurlencode($this->getSelection()),
			rawurlencode($this->getLanguage()),
		]);
	}

	public function getVideoUrl($proto, $selection=null)
	{
		if (!$selection) {
			$selection = $this->getSelection();
		}

		if($selection == 'slides') {
			return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'hls', rawurlencode($this->getRoom()->getStream()).'/Slides.m3u8']);
		}

		switch($proto)
		{
			case 'hls':
				return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'hls', rawurlencode($this->getRoom()->getStream()).'/'.rawurlencode($this->getLanguage()).'_'.rawurlencode($selection).'.m3u8']);
		}

		return null;
	}
	public function getVideoTech($proto)
	{
		switch($proto)
		{
			case 'hls':
				if($this->getSelection() == 'hd')
					return '1920x1080, h264+AAC im MPEG-TS-Container via HTTP, 3 MBit/s';

				else if($this->getSelection() == 'sd')
					return '1024x576, h264+AAC im MPEG-TS-Container via HTTP, 800 kBit/s';

			case 'dash':
				return 'VP9+Opus mit WebM-Segmenten';
		}

		return null;
	}
	public static function getVideoProtos()
	{
		return array(
			'hls' => 'HLS',
		);
	}

	public function getSlidesUrl($proto)
	{
		return $this->getVideoUrl($proto);
	}
	public function getSlidesTech($proto)
	{
		switch($proto)
		{
			case 'hls':
				return '1024x576, h264+AAC im MPEG-TS-Container via HTTP, 400 kBit/s';
		}

		return null;
	}
	public static function getSlidesProtos()
	{
		return Stream::getVideoProtos();
	}


	public function getAudioUrl($proto)
	{
		switch($proto)
		{
			case 'hls':
				return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'hls/'.rawurlencode($this->getRoom()->getStream()).'/segment_'.rawurlencode(ucfirst($this->getLanguage())).'.m3u8']);
		}

		return null;
	}
	public function getAudioTech($proto)
	{
		switch($proto)
		{
			case 'hls':
				return 'AAC, VBR';
		}

		return null;
	}
	public static function getAudioProtos()
	{
		return array(
			'hls' => 'HLS',
		);
	}

	public function getMusicUrl($proto)
	{
		switch($proto)
		{
			case 'mp3':
				return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], rawurlencode($this->getRoom()->getStream()).'.mp3']);

			case 'opus':
				return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], rawurlencode($this->getRoom()->getStream()).'.opus']);

			default:
				return null;
		}
	}
	public function getMusicTech($proto)
	{
		switch($proto)
		{
			case 'mp3':
				return 'MP3-Audio, 192 kBit/s';

			case 'opus':
				return 'Opus-Audio, 96 kBit/s';
		}

		return null;
	}
	public static function getMusicProtos()
	{
		return array(
			'mp3' => 'MP3',
			'opus' => 'Opus',
		);
	}
	public function getPoster() {
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'thumbnail', $this->getRoom()->getStream(), 'poster.jpeg']);
	}
}
