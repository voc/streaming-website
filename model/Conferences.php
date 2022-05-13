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
		return @Conferences::getFinishedConferencesSorted()[0];
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

		// try to find config.json for this conference/mandator in local configs
		$configfile = forceslash(Conferences::MANDATOR_DIR).forceslash($mandator).'config.json';

		if (file_exists($configfile)) {

			$data = file_get_contents($configfile); 
			$config = json_decode($data);
			
			if(is_null($config)) {
				throw new ConfigException("Loading $configfile did not return an object. Maybe it's not a real JSON file?" . json_last_error_msg());
			}

			return new ConferenceJson($config, $mandator);
		}


		// try to find config.php for this conference/mandator in local configs
		$configfile = forceslash(Conferences::MANDATOR_DIR).forceslash($mandator).'config.php';
	
		if (file_exists($configfile)) {
			$config = include($configfile);

			if(!is_array($config)) {
				throw new ConfigException("Loading $configfile did not return an array. Maybe it's missing a return-statement?");
			}

			$config = Conferences::migrateTranslationConfiguration($config);
			return new Conference($config, $mandator);
		}

		// otherwise try to find conference in c3data postgres
		$query = 'query StreamingConfig($acronym: String!) {
			conference(acronym: $acronym) {
				title
				acronym
				description
				keywords
				organizer
				startDate
				endDate
				streamingConfig 
				
				rooms(orderBy: [RANK_ASC, NAME_ASC], filter: {streamId: {isNull: false}}) {
					nodes {
						guid
						name
						slug
						streamId
						streamingConfig
					}
				}
			}
		}';
		$data = query_data('conferenceConfig', $query, ['acronym' => $mandator]);

		return new ConferenceJson($data, $mandator);
	}

	public static function getConference($mandator) {
		return Conferences::loadConferenceConfig($mandator);
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
