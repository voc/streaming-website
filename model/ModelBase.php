<?php

class Modelbase
{
	protected function has($keychain)
	{
		return $this->_has($GLOBALS['CONFIG'], $keychain);
	}
	private function _has($array, $keychain)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = $keychain[0];
		if(!isset($array[$key]))
			return false;

		if(count($keychain) == 1)
			return true;

		return $this->_has($array[$key], array_slice($keychain, 1));
	}

	protected function get($keychain, $default = null)
	{
		return $this->_get($GLOBALS['CONFIG'], $keychain, $default);
	}
	private function _get($array, $keychain, $default)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = $keychain[0];
		if(!isset($array[$key]))
			return $default;

		if(count($keychain) == 1)
			return $array[$key];

		return $this->_get($array[$key], array_slice($keychain, 1), $default);
	}
}
