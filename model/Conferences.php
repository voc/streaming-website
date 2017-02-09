<?php

namespace C3VOC\StreamingWebsite\Model;

class Conferences
{
	const MANDATOR_DIR = 'configs/conferences/';

	public static function listConferences() {
		$directories = scandir(forceslash(Conferences::MANDATOR_DIR));
		$conferences = array_filter($directories, function($dirname) {
			return $dirname[0] != '.';
		});

		return $conferences;
	}

	public static function getConferences() {
		$conferences = [];
		foreach(Conferences::listConferences() as $conference)
		{
			try {
				$conferences[$conference] = Conferences::getConference($conference);
			}
			catch(Exception $e) {
				// ignore unloadable conferences
			}
		}

		return $conferences;
	}
	public static function getConferencesCount() {
		return count(Conferences::listConferences());
	}

	public static function getActiveConferences() {
		return array_values(array_filter(
			Conferences::getConferencesSorted(),
			function($conference) {
				return !$conference->isClosed();
			}
		));
	}

	public static function getActiveConferencesCount() {
		return count(Conferences::getActiveConferences());
	}

	public static function getConferencesSorted() {
		$sorted = Conferences::getConferences();

		usort($sorted, function($a, $b) {
			return $b->startsAt() > $a->endsAt() ? 1 : -1;
		});

		return $sorted;
	}

	public static function getFinishedConferencesSorted() {
		$sorted = Conferences::getConferencesSorted();

		$finished = array_values(array_filter($sorted, function($c) {
			return $c->hasEnded();
		}));

		return $finished;
	}

	public static function getLastConference() {
		return Conferences::getFinishedConferencesSorted()[0];
	}

	public static function exists($mandator) {
		return in_array($mandator, Conferences::listConferences());
	}

	public static function loadConferenceConfig($mandator) {
		$configfile = forceslash(Conferences::MANDATOR_DIR).forceslash($mandator).'config.php';
		$config = include($configfile);

		if(!is_array($config)) {
			throw new ConfigException("Loading $configfile did not return an array. Maybe it's missing a return-statement?");
		}

		return $config;
	}

	public static function getConference($mandator) {
		return new Conference(Conferences::loadConferenceConfig($mandator), $mandator);
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
}
