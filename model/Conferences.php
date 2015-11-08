<?php

class Conferences extends ModelBase
{
	const MANDATOR_DIR = 'configs/conferences/';

	public static function getConferences() {
		return array_values(array_filter(scandir(forceslash(Conferences::MANDATOR_DIR)), function($el) {
			return $el[0] != '.';
		}));
	}
	public static function getConferencesCount() {
		return count(Conferences::getConferences());
	}

	public static function getActiveConferences() {
		return array_values(array_filter(
			Conferences::getConferences(), ['Conferences', 'isActive']
		));
	}

	public static function getActiveConferencesCount() {
		return count(Conferences::getActiveConferences());
	}

	public static function exists($mandator) {
		return in_array($mandator, Conferences::getConferences());
	}

	public static function isActive($mandator) {
		if(isset($GLOBALS['CONFIG']))
			$saved_config = $GLOBALS['CONFIG'];

		Conferences::load($mandator);
		$conf = new Conference();
		$active = !$conf->isClosed();
		unset($GLOBALS['CONFIG']);

		if(isset($saved_config))
			$GLOBALS['CONFIG'] = $saved_config;

		return $active;
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
		$GLOBALS['MANDATOR'] = $mandator;
		include(forceslash(Conferences::MANDATOR_DIR).forceslash($mandator).'config.php');
	}
}
