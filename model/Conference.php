<?php

class Conference extends ModelBase
{
	private $slug;
	private $schedule;

	public function __construct($config, $slug)
	{
		parent::__construct($config);
		$this->slug = $slug;
	}

	public function getSlug() {
		return $this->slug;
	}

	public function getTitle() {
		return $this->get('CONFERENCE.TITLE', 'C3VOC');
	}

	public function isPreviewEnabled() {
		if(@$GLOBALS['forceopen'])
			return true;

		if($this->has('PREVIEW_DOMAIN') && ($this->get('PREVIEW_DOMAIN') == $_SERVER['SERVER_NAME']))
			return true;

		return false;
	}

	public function isClosed() {
		return !$this->hasBegun() || $this->hasEnded();
	}

	public function isOpen() {
		return !$this->isClosed();
	}

	public function startsAt() {
		if(!$this->has('CONFERENCE.STARTS_AT'))
			return null;

		return DateTime::createFromFormat('U', $this->get('CONFERENCE.STARTS_AT'));
	}

	public function endsAt() {
		if(!$this->has('CONFERENCE.ENDS_AT'))
			return null;

		return DateTime::createFromFormat('U', $this->get('CONFERENCE.ENDS_AT'));
	}

	public function hasBegun() {
		// on the preview-domain all conferences are always open
		if($this->isPreviewEnabled())
			return true;

		if($this->has('CONFERENCE.CLOSED')) {
			$closed = $this->get('CONFERENCE.CLOSED');

			/* when CLOSED is a boolean, we're reading an old config where
			 * conferences didn't have a pre-beginning phase, thus we always
			 * return true.
			 */
			if(gettype($closed) == "boolean")
				return true;

			if($closed == "before")
				return false;
			else if($closed == "running" || $closed == "after")
				return true;
		}

		if($this->has('CONFERENCE.STARTS_AT')) {
			$now = new DateTime('now');
			return $now >= $this->startsAt();
		} else {
			return true;
		}
	}

	public function hasEnded() {
		// on the preview-domain no conference ever ends
		if($this->isPreviewEnabled())
			return false;

		if($this->has('CONFERENCE.CLOSED')) {
			$closed = $this->get('CONFERENCE.CLOSED');

			if($closed == "after" || $closed === true)
				return true;
			else if($closed == "running" || $closed == "before" ||
				$closed === false)
				return false;
		}

		if($this->has('CONFERENCE.ENDS_AT')) {
			$now = new DateTime('now');
			return $now >= $this->endsAt();
		} else {
			return false;
		}
	}

	public function isUnlisted() {
		if ($this->has('CONFERENCE.UNLISTED')) {
			$unlisted = $this->get('CONFERENCE.UNLISTED');
			return $unlisted === true;
		}
		else {
			return false;
		}
	}

	public function hasAuthor() {
		return $this->has('CONFERENCE.AUTHOR');
	}
	public function getAuthor() {
		return $this->get('CONFERENCE.AUTHOR', '');
	}

	public function hasDescription() {
		return $this->has('CONFERENCE.DESCRIPTION');
	}
	public function getDescription() {
		return $this->get('CONFERENCE.DESCRIPTION', '');
	}

	public function hasKeywords() {
		return $this->has('CONFERENCE.KEYWORDS');
	}
	public function getKeywords() {
		return $this->get('CONFERENCE.KEYWORDS', '');
	}



	public function hasReleases() {
		return $this->has('CONFERENCE.RELEASES');
	}
	public function getReleasesUrl() {
		return $this->get('CONFERENCE.RELEASES');
	}

	public function getLink() {
		return forceslash($this->getSlug()).url_params();
	}
	public function getAboutLink() {
		return joinpath([$this->getSlug(), 'about']).url_params();
	}

	public function hasRelive() {
		return $this->getRelive()->isEnabled();
	}
	public function getReliveUrl() {
		if($this->getRelive()->isEnabled())
			return joinpath([$this->getSlug(), 'relive']).url_params();

		else
			return null;
	}

	public function hasFeedback() {
		return $this->has('FEEDBACK');
	}
	public function getFeedbackUrl() {
		return joinpath([$this->getSlug(), 'feedback']).url_params();
	}
	public function getFeedbackReadUrl() {
		return joinpath([$this->getSlug(), 'feedback', 'read']).url_params();
	}

	public function getScheduleJsonUrl() {
		return joinpath([$this->getSlug(), 'schedule.json']).url_params();
	}

	public function hasBannerHtml() {
		return $this->has('CONFERENCE.BANNER_HTML');
	}
	public function getBannerHtml() {
		return $this->get('CONFERENCE.BANNER_HTML');
	}

	public function hasFooterHtml() {
		return $this->has('CONFERENCE.FOOTER_HTML');
	}
	public function getFooterHtml() {
		return $this->get('CONFERENCE.FOOTER_HTML');
	}

	public function hasNotStartedHtml() {
		return $this->has('CONFERENCE.NOT_STARTED_HTML');
	}
	public function getNotStartedHtml() {
		return $this->get('CONFERENCE.NOT_STARTED_HTML');
	}


	public function getRooms()
	{
		$rooms = array();
		foreach($this->get('ROOMS') as $slug => $room)
			$rooms[] = $this->getRoom($slug);

		return $rooms;
	}

	public function getRoomIfExists($room)
	{
		if($this->hasRoom($room))
			return $this->getRoom($room);

		return null;
	}

	public function hasRoom($slug)
	{
		return $this->has('ROOMS.'.$slug);
	}

	public function getRoom($room) {
		return new Room($this, $room);
	}


	public function getFeedback() {
		return new Feedback($this);
	}
	public function getSchedule() {
		if (!isset($this->schedule)) {
			return $this->schedule = new Schedule($this);
		}

		return $this->schedule;
	}
	public function getSubtitles() {
		return new Subtitles($this);
	}
	public function getOverview() {
		return new Overview($this);
	}
	public function getRelive() {
		return new Relive($this);
	}

	public function getExtraFiles() {
		return $this->get('EXTRA_FILES', []);
	}

	public function hasAdditionalHtml() {
		return $this->has('CONFERENCE.ADDITIONAL_HTML');
	}
	public function getAdditionalHtml() {
		return $this->get('CONFERENCE.ADDITIONAL_HTML');
	}
	public function getAdditionalLicenceHtml() {
		return $this->get('CONFERENCE.ADDITIONAL_LICENCE_HTML');
	}
}
