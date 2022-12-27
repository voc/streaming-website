<?php

class ConferenceJson extends Conference
{
	private $start;
	private $end;
	private $rooms;
	private $html;

	public function __construct($json, $mandator)
	{
		$c = $json->conference;
		$this->start = DateTime::createFromFormat('c', @$c->start ?: @$c->startDate);
		$this->end   = DateTime::createFromFormat('c', @$c->end   ?: @$c->endDate);
		$this->html  = @$c->streamingConfig->html ?: [];

		$this->rooms = [];
		$rooms = (is_array(@$c->rooms) ? $c->rooms : @$c->rooms->nodes) ?: [];
		foreach($rooms as $r) {
			if (!$r) {
				continue;
			}
			$this->rooms[$r->slug] = array_merge(
				['stream' => $r->streamId],
				get_object_vars($r), 
				@get_object_vars($r->streamingConfig) ?: [], 
				@get_object_vars($r->streamingConfig->chat) ?: []
			);
		}

		$groups = [];
		if ( isset($c->streamingConfig->overviewPage->sections) ) {
			foreach(@$c->streamingConfig->overviewPage->sections as $s) {
				$groups[@$s->title] = array_map(
					function($r) { return $r->slug; }, 
					@$s->items ?: @$s->rooms ?: []
				);
			}
		}
		else {
			$groups['Live'] = array_keys((array) $this->rooms);
		}
		
		$acronym = $mandator ?: $c->acronym;

		parent::__construct(array_merge(
			@get_object_vars($c->streamingConfig) ?: [], 
			@get_object_vars($c->streamingConfig->features) ?: [],
			@get_object_vars($c->streamingConfig->features->chat) ?: [],
			[
				'conference' => [
					'title' 		=> $c->title,
					'author' 		=> $c->organizer,
					'description' 	=> $c->description,
					'keywords'		=> @implode(', ', $c->keywords),
					// future TODO: change structure
					"relive_json"	=> @$c->streamingConfig->features->relive !== false ? "https://cdn.c3voc.de/relive/".$acronym."/index.json" : null,
					"releases"		=> @$c->streamingConfig->features->releases !== false ? "https://media.ccc.de/c/".$acronym : null
				], 
				// 'schedule' => (array) $c->streamingConfig->schedule
				'rooms' => $this->rooms,
				'overview' => [
					'groups' => $groups
				]
			]
		), $acronym);
	}

	public function has($keychain)
	{
		return ModelJson::_has($this->config, $keychain);
	}

	public function get($keychain, $default = null)
	{
		return ModelJson::_get($this->config, $keychain, $default);
	}

	/*
	public function getTitle() {
		return $this->data->conference->title;
	}

	public function hasAuthor() {
		return !empty($this->data->conference->organizer);
	}
	public function getAuthor() {
		return $this->data->conference->organizer ?: '';
	}
	*/

	public function startsAt() {
		return $this->start;
	}

	public function endsAt() {
		return $this->end;
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

		if($this->end) {
			$now = new DateTime('now');
			return $now >= $this->end;
		} else {
			return false;
		}
	}

	public function getRooms()
	{
		$rooms = array();
		foreach($this->rooms as $slug => $room)
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
		return array_key_exists($slug, $this->rooms);
	}

	public function getRoom($slug) {
		return new Room($this, $slug);
	}

	public function hasFeedback() {
		return $this->has('FEEDBACK');
	}

	public function hasBannerHtml() {
		return !empty($this->html->banner);
	}
	public function getBannerHtml() {
		return @$this->html->banner;
	}

	public function hasFooterHtml() {
		return !empty($this->html->footer);
	}
	public function getFooterHtml() {
		return @$this->html->footer;
	}

	public function hasNotStartedHtml() {
		return !empty($this->html->not_started);
	}
	public function getNotStartedHtml() {
		return @$this->html->not_started;
	}

}
