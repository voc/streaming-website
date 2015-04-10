<?php

class Room extends ModelBase
{
	private $slug;

	public function __construct($slug)
	{
		if(! $this->has('ROOMS.'.$slug))
			throw new NotFoundException('Room '.$slug);

		$this->slug = $slug;
	}

	public static function exists($slug)
	{
		return ModelBase::staticHas('ROOMS.'.$slug);
	}

	public static function createIfExists($room)
	{
		if(Room::exists($room))
			return new Room($room);

		return null;
	}

	public static function rooms()
	{
		$rooms = array();
		foreach(ModelBase::staticGet('ROOMS') as $slug => $room)
			$rooms[] = new Room($slug);

		return $rooms;
	}


	public function getSlug() {
		return $this->slug;
	}

	public function getThumb() {
		return 'thumbs/'.$this->getStream().'.png';
	}

	public function getLink() {
		return rawurlencode($this->getSlug()).'/';
	}

	public function getStream() {
		return $this->get('ROOMS.'.$this->getSlug().'.STREAM', $this->getSlug());
	}

	public function getScheduleName() {
		return $this->get('ROOMS.'.$this->getSlug().'.SCHEDULE_NAME', $this->getSlug());
	}

	public function getDisplay() {
		return $this->get('ROOMS.'.$this->getSlug().'.DISPLAY', $this->getSlug());
	}



	public function hasStereo() {
		return $this->get('ROOMS.'.$this->getSlug().'.STEREO');
	}

	public function hasPreview() {
		return $this->get('ROOMS.'.$this->getSlug().'.PREVIEW');
	}

	public function hasSchedule() {
		return $this->get('ROOMS.'.$this->getSlug().'.SCHEDULE') && $this->has('SCHEDULE');
	}

	public function hasFeedback() {
		return $this->get('ROOMS.'.$this->getSlug().'.FEEDBACK') && $this->has('FEEDBACK');
	}


	public function hasTwitter() {
		return $this->get('ROOMS.'.$this->getSlug().'.TWITTER') && $this->has('TWITTER');
	}

	public function getTwitterDisplay() {
		return sprintf(
			$this->get('ROOMS.'.$this->getSlug().'.TWITTER_CONFIG.DISPLAY', $this->get('TWITTER.DISPLAY')),
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
			$this->get('ROOMS.'.$this->getSlug().'.TWITTER_CONFIG.TEXT', $this->get('TWITTER.TEXT')),
			$this->getSlug()
		);
	}


	public function hasIrc() {
		return $this->get('ROOMS.'.$this->getSlug().'.IRC') && $this->has('IRC');
	}

	public function getIrcDisplay() {
		return sprintf(
			$this->get('ROOMS.'.$this->getSlug().'.IRC_CONFIG.DISPLAY', $this->get('IRC.DISPLAY')),
			$this->getSlug()
		);
	}

	public function getIrcUrl() {
		return sprintf(
			$this->get('ROOMS.'.$this->getSlug().'.IRC_CONFIG.URL', $this->get('IRC.URL')),
			rawurlencode($this->getSlug())
		);
	}


	public function hasChat() {
		return $this->hasTwitter() || $this->hasIrc();
	}


	public function hasEmbed() {
		return $this->get('ROOMS.'.$this->getSlug().'.EMBED') && $this->get('EMBED');
	}


	public function hasSdVideo() {
		return $this->get('ROOMS.'.$this->getSlug().'.SD_VIDEO');
	}

	public function hasHdVideo() {
		return $this->get('ROOMS.'.$this->getSlug().'.HD_VIDEO');
	}

	public function hasVideo() {
		return $this->hasSdVideo() || $this->hasHdVideo();
	}

	public function hasAudio() {
		return $this->get('ROOMS.'.$this->getSlug().'.AUDIO');
	}

	public function hasSlides() {
		return $this->get('ROOMS.'.$this->getSlug().'.SLIDES');
	}

	public function hasMusic() {
		return $this->get('ROOMS.'.$this->getSlug().'.MUSIC');
	}

	public function hasTranslation() {
		return $this->get('ROOMS.'.$this->getSlug().'.TRANSLATION');
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

		return $selections;
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

			if($this->hasTranslation())
				$streams[] = $this->createStreamObject($selection, 'translated');
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

		if($language == 'translated' && !$this->hasTranslation())
			throw new NotFoundException('Translated Streams of Room '.$this->getSlug());

		return $this->createStreamObject($selection, $language);
	}

	public function createStreamObject($selection, $language = 'native')
	{
		if($language == 'native' && $this->hasStereo())
			$language = 'stereo';

		return new Stream($this, $selection, $language);
	}
}
