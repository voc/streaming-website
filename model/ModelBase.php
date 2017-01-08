<?php

namespace C3VOC\StreamingWebsite\Model;

class ModelBase
{
	protected $config;
	public function __construct($config)
	{
		$this->config = $config;
	}

	public function has($keychain)
	{
		return ModelBase::_has($this->config, $keychain);
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

	public function get($keychain, $default = null)
	{
		return ModelBase::_get($this->config, $keychain, $default);
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
