<?php

class Room {
	private $slug;

	public static function get($slug)
	{
		return new Room($slug);
	}

	private function __construct($slug)
	{
		if(! has('ROOMS.'.$slug))
			throw new NotFoundException('Room '.$slug);

		$this->slug = $slug;
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
		return get('ROOMS.'.$this->getSlug().'.STREAM', $this->getSlug());
	}

	public function getDisplay() {
		return get('ROOMS.'.$this->getSlug().'.DISPLAY', $this->getSlug());
	}



	public function hasPreview() {
		return get('ROOMS.'.$this->getSlug().'.PREVIEW');
	}

	public function hasSchedule() {
		return get('ROOMS.'.$this->getSlug().'.SCHEDULE') && has('SCHEDULE');
	}
}
