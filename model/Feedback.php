<?php

class Feedback extends ModelBase
{
	public function isEnabled() {
		return $this->has('FEEDBACK');
	}
	public function getUrl() {
		return 'feedback/';
	}
}
