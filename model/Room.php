<?php

class Room
{
	private $slug;
	private $conference;

	public function __construct(Conference $conference, $slug)
	{
		$this->conference = $conference;

		if(preg_match('/[^a-z0-9_\-]/i', $slug))
			throw new Exception('Room Slug contains invalid Characters: "'.$slug.'"');

		if(!$this->getConference()->hasRoom($slug))
			throw new NotFoundException('Room '.$slug);

		$this->slug = $slug;
	}


	public function getConference() {
		return $this->conference;
	}

	public function getSlug() {
		return $this->slug;
	}

	public function getThumb() {
		return joinpath(['/', 'thumbs', $this->getStream().'.png']);
	}

	public function getLink() {
		return joinpath([$this->getConference()->getSlug(), $this->getSlug()]).url_params();
	}

	public function getStream() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.STREAM', $this->getSlug());
	}

	public function getScheduleName() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.SCHEDULE_NAME', $this->getDisplay());
	}

	public function getDisplay() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.DISPLAY', $this->getSlug());
	}



	public function hasStereo() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.STEREO');
	}

	public function hasPreview() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.PREVIEW');
	}

	public function requestsWide() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.WIDE');
	}

	public function hasSchedule() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.SCHEDULE') && $this->getConference()->has('SCHEDULE');
	}

	public function hasSubtitles() {
		return
			$this->getConference()->get('ROOMS.'.$this->getSlug().'.SUBTITLES') &&
			$this->getConference()->has('ROOMS.'.$this->getSlug().'.SUBTITLES_ROOM_ID') &&
			$this->getConference()->has('SUBTITLES');
	}
	public function getSubtitlesRoomId() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.SUBTITLES_ROOM_ID');
	}

	public function hasFeedback() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.FEEDBACK') && $this->getConference()->has('FEEDBACK');
	}


	public function hasTwitter() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.TWITTER') && $this->getConference()->has('TWITTER');
	}

	public function getTwitterDisplay() {
		return sprintf(
			$this->getConference()->get('ROOMS.'.$this->getSlug().'.TWITTER_CONFIG.DISPLAY', $this->getConference()->get('TWITTER.DISPLAY')),
			$this->getSlug()
		);
	}

	public function getTwitterUrl() {
		return sprintf(
			'https://twitter.com/search?q=%s',
			rawurlencode($this->getTwitterText())
		);
	}

	public function getTwitterText() {
		return sprintf(
			$this->getConference()->get('ROOMS.'.$this->getSlug().'.TWITTER_CONFIG.TEXT', $this->getConference()->get('TWITTER.TEXT')),
			$this->getSlug()
		);
	}


	public function hasIrc() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.IRC') && $this->getConference()->has('IRC');
	}

	public function getIrcDisplay() {
		return sprintf(
			$this->getConference()->get('ROOMS.'.$this->getSlug().'.IRC_CONFIG.DISPLAY', $this->getConference()->get('IRC.DISPLAY')),
			$this->getSlug()
		);
	}

	public function getIrcUrl() {
		return sprintf(
			$this->getConference()->get('ROOMS.'.$this->getSlug().'.IRC_CONFIG.URL', $this->getConference()->get('IRC.URL')),
			rawurlencode($this->getSlug())
		);
	}


	public function hasChat() {
		return $this->hasTwitter() || $this->hasIrc();
	}


	public function hasEmbed() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.EMBED') && $this->getConference()->get('EMBED');
	}


	public function hasSdVideo() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.SD_VIDEO');
	}

	public function hasHdVideo() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.HD_VIDEO');
	}

	public function hasVideo() {
		return $this->hasSdVideo() || $this->hasHdVideo();
	}

	public function hasAudio() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.AUDIO');
	}

	public function hasSlides() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.SLIDES');
	}

	public function hasMusic() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.MUSIC');
	}

	public function hasDash() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.DASH');
	}

	public function getHLSPlaylistUrl() {
		return proto().'://cdn.c3voc.de/hls/'.rawurlencode($this->getStream()).'_native.m3u8';
	}

	public function getDashManifestUrl() {
		return proto().'://cdn.c3voc.de/dash/'.rawurlencode($this->getStream()).'/manifest.mpd';
	}

	public function getDashTech() {
		return 'Adaptive multi-format-multi-bitrate-Stream to rule the World!!1elf';
	}

	public function getTranslations() {
		return $this->getConference()->get('ROOMS.'.$this->getSlug().'.TRANSLATION');
	}

	private function getTranslationEndpoints() {
		return array_map(
			function ($translation) {
				return $translation['endpoint'];
			},
			$this->getTranslations()
		);
	}

	private function isTranslationEndpoint($endpoint) {
		return in_array($endpoint, $this->getTranslationEndpoints());
	}

	private function findTranslationLabel($language) {
		foreach($this->getTranslations() as $translation) {
			if ($translation['endpoint'] === $language) {
				return $translation['label'];
			}
		}
		return null;
	}

	public function hasTranslation() {
		return count($this->getTranslations()) > 0;
	}

	public function  isValidLanguage($language) {
		return ($language === 'native' || $this->isTranslationEndpoint($language));
	}

	public function getSelectionNames()
	{
		$selections = array();
		if($this->hasHdVideo())
			$selections[] = 'hd';

		if($this->hasSdVideo())
			$selections[] = 'sd';

		if($this->hasSlides())
			$selections[] = 'slides';

		if($this->hasAudio())
			$selections[] = 'audio';

		if($this->hasMusic())
			$selections[] = 'music';

		if($this->hasDash())
			$selections[] = 'dash';

		return $selections;
	}

	public function isSelectionTranslated($selection) {
		# dash is special, has langs included
		return $selection !== 'dash' && $selection !== 'music';
	}

	public function getTabNames()
	{
		$tabs = array();
		if($this->hasVideo())
			$tabs[] = 'video';

		if($this->hasSlides())
			$tabs[] = 'slides';

		if($this->hasAudio())
			$tabs[] = 'audio';

		if($this->hasMusic())
			$tabs[] = 'music';

		if($this->hasDash())
			$tabs[] = 'dash';

		return $tabs;
	}

	public function getSelections()
	{
		$selections = array();
		foreach($this->getSelectionNames() as $selection)
			$selections[$selection] = $this->createSelectionObject($selection);

		return $selections;
	}

	public function createSelectionObject($selection = null)
	{
		if(!$selection)
		{
			$selections = $this->getSelectionNames();
			$selection = $selections[0];
		}

		return new RoomSelection($this, $selection);
	}

	public function getTabs()
	{
		$tabs = array();
		foreach($this->getTabNames() as $tab)
			$tabs[$tab] = $this->createTabObject($tab);

		return $tabs;
	}

	public function createTabObject($tab = null)
	{
		if(!$tab)
		{
			$tabs = $this->getTabNames();
			$tab = $tabs[0];
		}

		return new RoomTab($this, $tab);
	}

	public function getVideoResolutions()
	{
		$res = array();
		if($this->hasHdVideo())
			$res[] = 'hd';

		if($this->hasSdVideo())
			$res[] = 'sd';

		return $res;
	}

	public function getStreams()
	{
		$selections = $this->getSelectionNames();
		$streams = array();

		foreach ($selections as $selection) {
			$streams[] = $this->createStreamObject($selection, 'native');

			if ($this->isSelectionTranslated($selection)) {
				foreach ($this->getTranslations() as $translation) {
					$streams[] = $this->createStreamObject($selection, $translation['endpoint'], $translation['label']);
				}
			}
		}

		return $streams;
	}

	public function selectStream($selection, $language = 'native')
	{
		$selections = $this->getSelectionNames();

		if(count($selections) == 0)
			throw new NotFoundException('No Streams activated');

		// default page
		if(!$selection)
			$selection = $selections[0];

		if(!in_array($selection, $selections))
			throw new NotFoundException('Selection '.$selection.' in Room '.$this->getSlug());

		$translation_label = null;
		if ($language !== 'native' && $language !== 'stereo') {
			if (! $this->hasTranslation()) {
				throw new NotFoundException('Translated Streams of Room '. $this->getSlug());
			}
			if (! $this->isValidLanguage($language)) {
				throw new NotFoundException('Selected translation');
			}

			$translation_label = $this->findTranslationLabel($language);
		}

		return $this->createStreamObject($selection, $language, $translation_label);
	}

	public function createStreamObject($selection, $language = 'native', $languageLabel = null)
	{
		if($language == 'native' && $this->hasStereo())
			$language = 'stereo';

		return new Stream($this, $selection, $language, $languageLabel);
	}
}
