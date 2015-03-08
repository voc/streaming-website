<?php

class StreamList implements AggregateIterator {
	private $streams = array();

	public function getIterator() {
		return new ArrayIterator($this->streams);
	}


	public function hasTranslation() {
	}

	public function hasRTMP() {
	}

	public function hasHLS() {
	}

	public function hasWebM() {
	}

	public function hasHD() {
	}

	public function hasSD() {
	}
}
