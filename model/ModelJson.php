<?php

class ModelJson
{
	protected $config;
	public function __construct($config)
	{
		$this->config = $config;
	}

	public function has($keychain)
	{
		return ModelJson::_has($this->config, $keychain);
	}

	public static function _has($array, $keychain)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = strtolower($keychain[0]);
		if(!isset($array[$key]))
			return false;

		if(count($keychain) == 1)
			return true;

		return ModelJson::_has($array[$key], array_slice($keychain, 1));
	}

	public function get($keychain, $default = null)
	{
		return ModelJson::_get($this->config, $keychain, $default);
	}

	public static function _get($array, $keychain, $default)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = strtolower($keychain[0]);
		if(!isset($array[$key]))
			return $default;

		if(count($keychain) == 1)
			return $array[$key];

		return ModelJson::_get($array[$key], array_slice($keychain, 1), $default);
	}
}
