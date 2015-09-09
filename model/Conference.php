<?php

class Conference extends ModelBase
{
	public function getTitle() {
		return $this->get('CONFERENCE.TITLE', 'C3Voc Streaming');
	}

	public function isClosed() {
		return !$this->hasBegun() || $this->hasEnded();
	}

	public function hasBegun() {
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
			return time() >= $this->get('CONFERENCE.STARTS_AT');
		} else {
			return true;
		}
	}

	public function hasEnded() {
		if($this->has('CONFERENCE.CLOSED')) {
			$closed = $this->get('CONFERENCE.CLOSED');

			if($closed == "after" || $closed === true)
				return true;
			else if($closed == "running" || $closed == "before" ||
				$closed === false)
				return false;
		}

		if($this->has('CONFERENCE.ENDS_AT')) {
			return time() >= $this->get('CONFERENCE.ENDS_AT');
		} else {
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

	public function hasRelive() {
		return $this->has('CONFERENCE.RELIVE_JSON');
	}
	public function getReliveUrl() {
		if($this->has('CONFERENCE.RELIVE_JSON'))
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
