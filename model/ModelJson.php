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

	public static function _has($model, $keychain)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = strtolower($keychain[0]);
		if(is_array($model) ? !isset($model[$key]) : !isset($model->$key))
			return false;

		if(count($keychain) == 1)
			return true;

		$value = is_array($model) ? $model[$key] : $model->$key;
		return ModelJson::_has($value, array_slice($keychain, 1));
	}

	public function get($keychain, $default = null)
	{
		return ModelJson::_get($this->config, $keychain, $default);
	}

	public static function _get($model, $keychain, $default)
	{
		if(!is_array($keychain))
			$keychain = explode('.', $keychain);

		$key = strtolower($keychain[0]);
		if (is_array($model) ? !isset($model[$key]) : !isset($model->$key))
			return $default;

		$value = is_array($model) ? $model[$key] : $model->$key;
		if(count($keychain) == 1)
			return $value;

		return ModelJson::_get($value, array_slice($keychain, 1), $default);
	}
}
