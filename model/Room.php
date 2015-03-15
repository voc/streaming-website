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

	public function getDisplay() {
		return $this->get('ROOMS.'.$this->getSlug().'.DISPLAY', $this->getSlug());
	}



	public function hasPreview() {
		return get('ROOMS.'.$this->getSlug().'.PREVIEW');
	}

	public function hasSchedule() {
		return $this->get('ROOMS.'.$this->getSlug().'.SCHEDULE') && $this->has('SCHEDULE');
	}
}
