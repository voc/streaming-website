<?php

class ConferenceJson extends Conference
{
	private $start;
	private $end;
	private $rooms;
	private $streamingConfig;
	private $html;

	public function __construct($json, $mandator)
	{
		$c = $json->conference;
		$this->start = isset($c->start) ? DateTime::createFromFormat(DateTimeInterface::ISO8601, $c->start) : null;
		$this->end   = isset($c->end)   ? DateTime::createFromFormat(DateTimeInterface::ISO8601, $c->end) : null;
		$this->html  = isset($c->streamingConfig->html) ? $c->streamingConfig->html : [];
		$this->streamingConfig = $c->streamingConfig;
		$this->rooms = [];
		if (isset($c->rooms)) {
			if (is_array($c->rooms)) {
				$rooms = $c->rooms;
			} else {
				$rooms = isset($c->rooms->nodes) ? $c->rooms->nodes : [];
			}
		}
		foreach($rooms as $r) {
			if (!$r) {
				continue;
			}
			$streamId = isset($r->streamId) ? $r->streamId : $r->slug;
			$this->rooms[$r->slug] = array_merge(
				['stream' => $streamId],
				get_object_vars($r),
				(isset($r->streamingConfig) ? get_object_vars($r->streamingConfig) : []),
				(isset($r->streamingConfig->chat) ? get_object_vars($r->streamingConfig->chat) : [])
			);
		}

		$groups = [];
		if ( isset($c->streamingConfig->overviewPage->sections) ) {
			foreach($c->streamingConfig->overviewPage->sections as $s) {
				$groups[$s->title] = array_map(
					function($r) { return $r->slug; },
					@$s->items ?: @$s->rooms ?: []
				);
			}
		}
		else {
			$groups['Live'] = array_keys((array) $this->rooms);
		}

		$acronym = $c->acronym ?: $mandator;

		$config = array_merge(
			isset($c->streamingConfig) ? get_object_vars($c->streamingConfig) : [],
			isset($c->streamingConfig->features) ? get_object_vars($c->streamingConfig->features) : [],
			isset($c->streamingConfig->features->chat) ? get_object_vars($c->streamingConfig->features->chat) : [],
			[
				'conference' => [
					'title' 		=> $c->title,
					'author' 		=> $c->organizer,
					'description' 	=> $c->description,
					'keywords'		=> is_array($c->keywords) ? implode(', ', $c->keywords) : "",
					// future TODO: change structure
					"relive_json"	=> "https://cdn.c3voc.de/relive/".$acronym."/index.json",
					"releases"		=> "https://media.ccc.de/c/".$acronym,
				],
				// 'schedule' => (array) $c->streamingConfig->schedule
				'rooms' => $this->rooms,
				'overview' => [
					'groups' => $groups
				]
			]
		);

		// disable relive button
		if (isset($c->streamingConfig->features->relive) && $c->streamingConfig->features->relive === false) {
			$config['conference']['relive_json'] = null;
		}

		// disable releases button
		if (isset($c->streamingConfig->features->releases) && $c->streamingConfig->features->releases === false) {
			$config['conference']['releases'] = null;
		}

		parent::__construct($config, $mandator);
	}

	public function has($keychain)
	{
		return ModelJson::_has($this->config, $keychain);
	}

	public function get($keychain, $default = null)
	{
		return ModelJson::_get($this->config, $keychain, $default);
	}

	public function startsAt() {
		return $this->start;
	}

	public function endsAt() {
		return $this->end;
	}

	public function hasBegun() {
		// on the preview-domain all conferences are always open
		if($this->isPreviewEnabled() || empty($this->start))
			return true;

		$now = new DateTime('now');
		return $now >= $this->start;
	}

	public function hasEnded() {
		// on the preview-domain no conference ever ends
		if($this->isPreviewEnabled() || empty($this->end))
			return false;

		$now = new DateTime('now');
		return $now >= $this->end;
	}

	public function isUnlisted() {
		return empty($this->start) || empty($this->end);
	}

	public function getStreamingConfig() {
		return $this->streamingConfig;
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
		return isset($this->streamingConfig->features->feedback) ? $this->streamingConfig->features->feedback : false;
	}

	public function hasBannerHtml() {
		return !empty($this->html->banner);
	}
	public function getBannerHtml() {
		return isset($this->html->banner) ? $this->html->banner : "";
	}

	public function hasFooterHtml() {
		return !empty($this->html->footer);
	}
	public function getFooterHtml() {
		return isset($this->html->footer) ? $this->html->footer : "";
	}

	public function hasNotStartedHtml() {
		return !empty($this->html->not_started);
	}
	public function getNotStartedHtml() {
		return isset($this->html->not_started) ? $this->html->not_started : "";
	}

}
