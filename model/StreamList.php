<?php

class StreamList extends ModelBase implements IteratorAggregate
{
	private $streams = array();

	public function __construct($slug)
	{
		if(! $this->has('ROOMS.'.$slug))
			throw new NotFoundException('Room '.$slug);

		$this->slug = $slug;
		$this->streams = array();

		$streams = $this->get("ROOMS.$slug.STREAMS");
		foreach((array)$streams as $stream) {
			$this->streams[$stream] = explode('-', $stream);
		}
	}

	public function getRoomSlug() {
		return $this->slug;
	}

	public function getRoom() {
		return new Room($this->getRoomSlug());
	}

	public function getStreams() {
		return array_keys($this->streams);
	}

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
