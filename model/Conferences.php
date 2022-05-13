<?php

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
				return !$conference->isClosed() && !$conference->isUnlisted();
			}
		));
	}

	public static function getActiveConferencesCount() {
		return count(Conferences::getActiveConferences());
	}

	public static function getConferencesSorted() {
		$sorted = Conferences::getConferences();

		usort($sorted, function($a, $b) {
			return $b->startsAt() > $a->startsAt() ? 1 : -1;
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

	private static function migrateTranslationConfiguration($config) {
		// Allow setting TRANSLATION simply to true and fill in default values for uniformity
		$rooms = $config['ROOMS'];
		foreach ($rooms as $slug => $room) {
			// Translation is commented out, equaivalent of false
			if (!isset($room['TRANSLATION'])) {
				$config['ROOMS'][$slug]['TRANSLATION'] = [];
			}
			// Translation is present but not an array
			elseif (! is_array($room['TRANSLATION'])) {
				// Translation is true, set default values
				if ($room['TRANSLATION'] === true) {
					$config['ROOMS'][$slug]['TRANSLATION'] = [[
						'endpoint' => 'translated',
						'label'    => 'Translated'
					]];
				}
				// Translation is false or garbage
				else {
					$config['ROOMS'][$slug]['TRANSLATION'] = [];
				}
			}
		}

		return $config;
	}

	public static function loadConferenceConfig($mandator) {
		$configfile = forceslash(Conferences::MANDATOR_DIR).forceslash($mandator).'config.php';

		try {
			$config = include($configfile);
		}
		catch(Exception $e) {
			throw new NotFoundException();
		}

		if(!is_array($config)) {
			throw new ConfigException("Loading $configfile did not return an array. Maybe it's missing a return-statement?");
		}

		$config = Conferences::migrateTranslationConfiguration($config);

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
