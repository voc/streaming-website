<?php

class GenericConference extends Conference
{
	public function getTitle() {
		return 'C3Voc Streaming';
	}

	public function hasBegun() {
		return true;
	}

	public function hasEnded() {
		return true;
	}

	public function hasAuthor() {
		return true;
	}
	public function getAuthor() {
		return 'C3Voc';
	}

	public function hasDescription() {
		return true;
	}
	public function getDescription() {
		return 'Video Live-Streaming of the CCC';
	}

	public function hasKeywords() {
		return true;
	}
	public function getKeywords() {
		return 'Video, Media, Streaming, VOC, C3Voc, CCC';
	}



	public function hasReleases() {
		return true;
	}
	public function getReleasesUrl() {
		return '//media.ccc.de/';
	}

	public function hasRelive() {
		return false;
	}
	public function getReliveUrl() {
		return null;
	}

	public function hasBannerHtml() {
		return false;
	}
	public function getBannerHtml() {
		return null;
	}

	public function hasFooterHtml() {
		return false;
	}
	public function getFooterHtml() {
		return null;
	}
}
