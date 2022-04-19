<?php

class Room
{
	private $slug;
	private $conference;
	private $talks;

	public function __construct(Conference $conference, $slug)
	{
		$this->conference = $conference;

		if(preg_match('/[^a-z0-9_\-]/i', $slug))
			throw new Exception('Room Slug contains invalid Characters: "'.$slug.'"');

		if(!$this->getConference()->hasRoom($slug))
			throw new NotFoundException('Room '.$slug);

		$this->slug = $slug;

		$schedule = $conference->getSchedule();
		$talksPerRoom = $schedule->getSchedule();
		$scheduleName = $this->getScheduleName();

		$this->talks = isset($talksPerRoom[$scheduleName]) ? $talksPerRoom[$scheduleName] : [];
	}

	public function getCurrentTalk($now)
	{
		return array_filter_last($this->talks, function($talk) use ($now) {
			return $talk['start'] < $now && $talk['end'] > $now;
		});
	}

	public function getNextTalk($now)
	{
		return array_filter_first($this->talks, function($talk) use ($now) {
			return !isset($talk['special']) && $talk['start'] > $now;
		});
	}

	public function getConference() {
		return $this->conference;
	}

	public function getSlug() {
		return $this->slug;
	}

	private function get($key, $fallbackValue = null) {
		$keychain = 'ROOMS.'.$this->getSlug().'.'.$key;
		return $this->conference->get($keychain, $fallbackValue ?: @$GLOBALS['CONFIG']['ROOM_DEFAULTS'][$key]);
	}

	private function has($key) {
		return $this->conference->has('ROOMS.'.$this->getSlug().'.'.$key);
	}

	public function getThumb() {
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'thumbnail', $this->getStream(), 'thumb.jpeg']);
	}

	public function getPoster() {
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'thumbnail', $this->getStream(), 'poster.jpeg']);
	}

	public function getLink() {
		return joinpath([$this->getConference()->getSlug(), $this->getSlug()]).url_params();
	}

	public function getStream() {
		return $this->get('STREAM') ?: $this->get('streamId') ?: $this->getSlug();
	}

	public function getScheduleName() {
		return $this->get('SCHEDULE_NAME', $this->getDisplay());
	}

	public function getDisplay() {
		return $this->get('DISPLAY') ?: $this->get('name') ?: $this->getSlug();
	}

	public function getDisplayShort() {
		$display_short = $this->get('DISPLAY_SHORT', '');
		if (empty($display_short)) {
			return $this->getDisplay(); // getDisplay() falls back to slug
		}
		else {
			return $display_short;
		}
	}

	public function h264Only() {
		return $this->get('H264_ONLY');
	}

	public function hasStereo() {
		return $this->get('STEREO');
	}

	public function hasPreview() {
		return $this->get('PREVIEW');
	}

	public function requestsWide() {
		return $this->get('WIDE');
	}

	public function hasSchedule() {
		return $this->get('SCHEDULE') && $this->getConference()->has('SCHEDULE');
	}

	public function hasSubtitles() {
		return
			$this->get('SUBTITLES') &&
			$this->has('SUBTITLES_ROOM_ID') &&
			$this->getConference()->has('SUBTITLES');
	}
	public function getSubtitlesRoomId() {
		return $this->get('SUBTITLES_ROOM_ID');
	}

	public function hasFeedback() {
		return $this->get('FEEDBACK') && $this->getConference()->has('FEEDBACK');
	}


	public function hasTwitter() {
		return $this->get('TWITTER') && $this->getConference()->has('TWITTER');
	}

	public function getTwitterDisplay() {
		return sprintf(
			$this->get('TWITTER_CONFIG.DISPLAY', $this->getConference()->get('TWITTER.DISPLAY')),
			$this->getSlug()
		);
	}

	public function getTwitterUrl() {
		return sprintf(
			'https://twitter.com/search?f=tweets&q=%s',
			rawurlencode($this->getTwitterText())
		);
	}

	public function getTwitterText() {
		return sprintf(
			$this->get('TWITTER_CONFIG.TEXT', $this->getConference()->get('TWITTER.TEXT')),
			$this->getSlug()
		);
	}


	public function hasIrc() {
		return $this->get('IRC') && $this->getConference()->has('IRC');
	}

	public function getIrcDisplay() {
		return sprintf(
			$this->get('IRC_CONFIG.DISPLAY', $this->getConference()->get('IRC.DISPLAY')),
			$this->getSlug()
		);
	}

	public function getIrcUrl() {
		return sprintf(
			$this->get('IRC_CONFIG.URL', $this->getConference()->get('IRC.URL')),
			rawurlencode($this->getSlug())
		);
	}

	public function hasWebchat() {
		return $this->get('WEBCHAT') && $this->getConference()->has('WEBCHAT_URL');
	}

	public function getWebchatUrl() {
		return sprintf(
			$this->get('WEBCHAT_URL', $this->getConference()->get('WEBCHAT_URL')),
			rawurlencode($this->getSlug())
		);
	}

	public function hasChat() {
		return $this->hasTwitter() || $this->hasIrc() || $this->hasWebchat();
	}


	public function hasEmbed() {
		return $this->get('EMBED') && $this->getConference()->get('EMBED');
	}

	public function hasInfo() {
		return $this->get('INFO') && $this->getConference()->get('INFO');
	}

	public function getInfo() {
		return $this->get('INFO');
	}
	
	public function hasSdVideo() {
		return $this->get('SD_VIDEO');
	}

	public function hasHdVideo() {
		return $this->get('HD_VIDEO');
	}

	public function hasAudio() {
		return $this->get('AUDIO');
	}

	public function hasSlides() {
		return $this->get('SLIDES');
	}

	public function hasMusic() {
		return $this->get('MUSIC');
	}

	public function hasDash() {
		return $this->get('DASH');
	}

	public function getHLSPlaylistUrl() {
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'hls', rawurlencode($this->getStream()).'/native_hd.m3u8']);
	}

	public function getDashManifestUrl() {
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'dash', rawurlencode($this->getStream()).'/manifest.mpd']);
	}

	public function getDashTech() {
		return 'Adaptive multi-format-multi-bitrate-Stream to rule the World!!1elf';
	}

	public function getTranslations() {
		return $this->get('TRANSLATION');
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
		if($this->hasDash())
			if($this->h264Only())
				$selections[] = 'hls';
			else
				$selections[] = 'dash';

		if($this->hasAudio())
			$selections[] = 'audio';

		if($this->hasMusic())
			$selections[] = 'music';

		if($this->hasSlides())
			$selections[] = 'slides';

		return $selections;
	}

	public function isSelectionTranslated($selection) {
		# dash is special, has langs included
		return $selection !== 'dash' && $selection !== 'music';
	}

	public function getTabNames()
	{
		$tabs = array();
		if($this->hasDash())
			$tabs[] = 'dash';

		if($this->hasAudio())
			$tabs[] = 'audio';

		if($this->hasMusic())
			$tabs[] = 'music';

		if($this->hasSlides())
			$tabs[] = 'slides';

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
		$selections[] = "hd";
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
		if($selection == 'video') $selection = 'hd';
		$selections = $this->getSelectionNames();

		if(count($selections) == 0)
			throw new NotFoundException('No Streams activated');

		// default page
		if(!$selection)
			$selection = $selections[0];

		if(!in_array($selection, $selections))
			throw new NotFoundException('Selection '.$selection.' in Room '.$this->getSlug());

		$translation_label = null;
		if ($language !== 'native') {
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
		return new Stream($this, $selection, $language, $languageLabel);
	}
}
