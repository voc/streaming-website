<?php

class ModelBase
{
	protected function has($keychain)
	{
		return ModelBase::_has($GLOBALS['CONFIG'], $keychain);
	}
	protected static function staticHas($keychain)
	{
		return ModelBase::_has($GLOBALS['CONFIG'], $keychain);
	}
	private static function _has($array, $keychain)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = $keychain[0];
		if(!isset($array[$key]))
			return false;

		if(count($keychain) == 1)
			return true;

		return ModelBase::_has($array[$key], array_slice($keychain, 1));
	}

	protected function get($keychain, $default = null)
	{
		return ModelBase::_get($GLOBALS['CONFIG'], $keychain, $default);
	}
	protected static function staticGet($keychain, $default = null)
	{
		return ModelBase::_get($GLOBALS['CONFIG'], $keychain, $default);
	}
	private static function _get($array, $keychain, $default)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = $keychain[0];
		if(!isset($array[$key]))
			return $default;

		if(count($keychain) == 1)
			return $array[$key];

		return ModelBase::_get($array[$key], array_slice($keychain, 1), $default);
	}
}
