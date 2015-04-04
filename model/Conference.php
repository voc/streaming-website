<?php

class Conference extends ModelBase
{
	public function getTitle() {
		return $this->get('CONFERENCE.TITLE', 'C3Voc Streaming');
	}

	public function isClosed() {
		return $this->get('CONFERENCE.CLOSED');
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

	public function hasRelive() {
		return $this->has('CONFERENCE.RELIVE') || $this->has('CONFERENCE.RELIVE_JSON');
	}
	public function getReliveUrl() {
		if($this->has('CONFERENCE.RELIVE'))
			return $this->get('CONFERENCE.RELIVE');

		elseif($this->has('CONFERENCE.RELIVE_JSON'))
			return 'relive/';

		else
			return null;
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
}
