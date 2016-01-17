<?php

class Conferences extends ModelBase
{
	const MANDATOR_DIR = 'configs/conferences/';

	public static function getConferences() {
		$conferences = [];
		foreach(scandir(forceslash(Conferences::MANDATOR_DIR)) as $el)
		{
			if($el[0] == '.')
				continue;

			$conferences[$el] = Conferences::getConferenceInformation($el);
		}

		return $conferences;
	}
	public static function getConferencesCount() {
		return count(Conferences::getConferences());
	}

	public static function getActiveConferences() {
		return array_values(array_filter(
			Conferences::getConferences(),
			function($info) {
				return $info['active'];
			}
		));
	}

	public static function getActiveConferencesCount() {
		return count(Conferences::getActiveConferences());
	}

	public static function getConferencesSorted() {
		$sorted = Conferences::getConferences();

		usort($sorted, function($a, $b) {
			return @$b['CONFIG']['CONFERENCE']['STARTS_AT'] - @$a['CONFIG']['CONFERENCE']['STARTS_AT'];
		});

		return $sorted;
	}

	public static function getFinishedConferencesSorted() {
		$sorted = Conferences::getConferencesSorted();

		$finished = array_values(array_filter($sorted, function($c) {
			return @$c['CONFIG']['CONFERENCE']['ENDS_AT'] < time();
		}));

		return $finished;
	}

	public static function getLastConference() {
		return Conferences::getFinishedConferencesSorted()[0];
	}

	public static function exists($mandator) {
		return array_key_exists($mandator, Conferences::getConferences());
	}

	public static function getConferenceInformation($mandator) {
		if(isset($GLOBALS['CONFIG']))
			$saved_config = $GLOBALS['CONFIG'];

		Conferences::load($mandator);
		$conf = new Conference();
		$info = [
			'slug' => $mandator,
			'link' => forceslash($mandator),
			'active' => !$conf->isClosed(),
			'title' => $conf->getTitle(),
			'description' => $conf->getDescription(),

			'relive' => $conf->hasRelive() ? forceslash($mandator).$conf->getReliveUrl() : null,
			'releases' => $conf->hasReleases() ? $conf->getReleasesUrl() : null,

			'CONFIG' => $GLOBALS['CONFIG'],
		];
		unset($GLOBALS['CONFIG']);

		if(isset($saved_config))
			$GLOBALS['CONFIG'] = $saved_config;

		return $info;
	}

	public static function hasCustomStyles($mandator) {
		return file_exists(Conferences::getCustomStyles($mandator));
	}
	public static function getCustomStyles($mandator) {
		return forceslash(Conferences::getCustomStylesDir($mandator)).'main.less';
	}
	public static function getCustomStylesDir($mandator) {
		return forceslash(Conferences::MANDATOR_DIR).forceslash($mandator);
	}

	public static function load($mandator) {
		include(forceslash(Conferences::MANDATOR_DIR).forceslash($mandator).'config.php');
		return isset($GLOBALS['CONFIG']);
	}
}
