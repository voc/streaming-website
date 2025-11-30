<?php

class Room
{
	private $guid;
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
		$this->guid = $this->get('GUID');

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

	public function getId() {
		return $this->guid;
	}

	public function getSlug() {
		if ($this->slug != NULL) {
			return $this->slug;
		} else {
			return "";
		}
	}

	private function get($key, $fallbackValue = null) {
		$keychain = 'ROOMS.'.$this->getSlug().'.'.$key;
		$fallback = null;
		if (isset($GLOBALS['CONFIG']['ROOM_DEFAULTS'][$key])) {
			$fallback = $GLOBALS['CONFIG']['ROOM_DEFAULTS'][$key];
		}
		return $this->conference->get($keychain, $fallbackValue ?: $fallback);
	}

	private function has($key) {
		return $this->conference->has('ROOMS.'.$this->getSlug().'.'.$key);
	}

	public function getThumb() {
		if ($this->conference->has('cdn.thumbnail_url')) {
			return str_replace('{streamId}', $this->getStream(), $this->conference->get('cdn.thumbnail_url'));
		}
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'thumbnail', $this->getStream(), 'thumb.jpeg']);
	}

	public function getPoster() {
		if ($this->conference->has('cdn.poster_url')) {
			return str_replace('{streamId}', $this->getStream(), $this->conference->get('cdn.poster_url'));
		}
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'thumbnail', $this->getStream(), 'poster.jpeg']);
	}

	public function getLink() {
		return joinpath([$this->getConference()->getSlug(), $this->getSlug()]).url_params();
	}

	public function getStream() {
		return $this->get('STREAM') ?: $this->get('streamId') ?: $this->getSlug();
	}

	public function getScheduleName() {
		return $this->get('SCHEDULE_NAME') ?: $this->get('name') ?: $this->getDisplay();
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
		return $this->get('PREVIEW', true);
	}

	public function requestsWide() {
		return $this->get('WIDE');
	}

	public function hasSchedule() {
		return $this->get('SCHEDULE', true) && $this->getConference()->has('SCHEDULE');
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
		return $this->get('FEEDBACK') && $this->getConference()->hasFeedback();
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
			$this->get('TWITTER_CONFIG.TEXT') ?: $this->getConference()->get('TWITTER.TEXT') ?: $this->getHashtag(),
			$this->getSlug()
		);
	}

	public function hasMastodon() {
		return $this->get('social.mastodon') && $this->getConference()->get('social') !== false;
	}

	public function getMastodonUrl() {
		return sprintf(
			'https://chaos.social/tags/%s',
			substr($this->getHashtag(), 1)
		);
	}

	public function getHashtag() {
		return sprintf(
			$this->get('social.hashtag') ?: $this->getConference()->get('social.hashtag'),
			$this->getSlug()
		);
	}

	public function hasMatrix() {
		return $this->get('chat.matrix') && $this->getConference()->has('chat');
	}

	public function getMatrixDisplay() {
		return sprintf(
			$this->get('chat.matrix.display') ?: $this->getConference()->get('chat.matrix.display'),
			$this->getSlug()
		);
	}

	public function getMatrixUrl() {
		return sprintf(
			$this->get('chat.matrix.url') ?: $this->getConference()->get('chat.matrix.url'),
			rawurlencode($this->getSlug())
		);
	}


	public function hasIrc() {
		$irc = $this->get('IRC');
		return $this->getConference()->has('IRC') && (is_array($irc) ? count($irc) : $irc);
	}

	public function getIrcDisplay() {
		return sprintf(
			$this->get('IRC_CONFIG.DISPLAY') ?: $this->get('irc.display') ?: $this->getConference()->get('IRC.DISPLAY'),
			$this->getSlug()
		);
	}

	public function getIrcUrl() {
		return sprintf(
			$this->get('IRC_CONFIG.URL') ?: $this->get('irc.url') ?: $this->getConference()->get('IRC.URL'),
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
		$chat = $this->get('CHAT');
		return ((is_array($chat) ? count($chat) : $chat) && $this->getConference()->has('CHAT')) 
			|| $this->hasIrc() || $this->hasWebchat() || $this->hasTwitter();
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
		return $this->get('AUDIO') && $this->getConference()->get('AUDIO') !== FALSE;
	}

	public function hasSlides() {
		return $this->get('SLIDES');
	}

	public function hasMusic() {
		return $this->get('MUSIC');
	}

	public function hasDash() {
		return $this->get('DASH', true);
	}

	public static function clientQualifiesForLowLatency()
	{
		$IPV6_RANGE = '2001:67c:20a1:';         // Club event range
		$IPV4_RANGES = [
			['94.45.224.0', '94.45.255.255'],   // Club event range
			['151.219.0.0', '151.219.255.255'], // Temporary RIPE assignment
			['10.0.0.0', '10.255.255.255']      // Local network
		];
		$ip = $_SERVER['REMOTE_ADDR'];

		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			return (strpos($ip, $IPV6_RANGE) === 0);
		}

		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$longIp = ip2long($ip);
			foreach ($IPV4_RANGES as $range) {
				if ($longIp >= ip2long($range[0]) && $longIp <= ip2long($range[1])) {
					return true;
				}
			}
		}
		return false;
	}

	public function hasHdLowLatencyVideo() {
		return $this->get('HD_LL_VIDEO', true) && self::clientQualifiesForLowLatency();
	}

	public function hasCustomHLSStreamingUrl() {
		return $this->conference->has('cdn.hls_playlist_url');
	}

	public function hasCustomHLSLLStreamingUrl() {
		return $this->conference->has('cdn.hlsll_playlist_url');
	}

	public function getHLSPlaylistUrl() {
		if ($this->conference->has('cdn.hls_playlist_url')) {
			return str_replace('{streamId}', rawurlencode($this->getStream()), $this->conference->get('cdn.hls_playlist_url'));
		}
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'hls', rawurlencode($this->getStream()).'/native_hd.m3u8']);
	}

	public function getHLSLLPlaylistUrl() {
		if ($this->conference->has('cdn.hlsll_playlist_url')) {
			return str_replace('{streamId}', rawurlencode($this->getStream()), $this->conference->get('cdn.hlsll_playlist_url'));
		}
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'hlsll', rawurlencode($this->getStream()).'/native_hd.m3u8']);
	}

	public function getDashManifestUrl() {
		if ($this->conference->has('cdn.dash_manifest_url')) {
			return str_replace('{streamId}', rawurlencode($this->getStream()), $this->conference->get('cdn.dash_manifest_url'));
		}
		return proto().'://'.joinpath([$GLOBALS['CONFIG']['CDN'], 'dash', rawurlencode($this->getStream()).'/manifest.mpd']);
	}

	public function getDashTech() {
		return 'Adaptive multi-format-multi-bitrate-Stream to rule the World!!1elf';
	}

	public function getTranslations() {
		return $this->get('TRANSLATION') ?: [];
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

	public function isValidLanguage($language) {
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

		if($this->hasHdLowLatencyVideo())
			$selections[] = 'hlsll';

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

		if($this->hasHdLowLatencyVideo())
			$tabs[] = 'hlsll';

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
