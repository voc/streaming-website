<?php

function baseurl()
{
	if(isset($GLOBALS['CONFIG']['baseurl']))
		return $GLOBALS['CONFIG']['baseurl'];

	$base  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://';
	$base .= $_SERVER['HTTP_HOST'];
	$base .=  forceslash(dirname($_SERVER['SCRIPT_NAME']));

	return $base;
}

function forceslash($url)
{
	$url =  rtrim($url, '/');
	if(strlen($url) > 0)
		$url .= '/';

	return $url;
}

function has($keychain)
{
	return _has($GLOBALS['CONFIG'], $keychain);
}
function _has($array, $keychain)
{
	if(!is_array($keychain))
		$keychain = explode('.', $keychain);

	$key = $keychain[0];
	if(!isset($array[$key]))
		return false;

	if(count($keychain) == 1)
		return true;

	return _has($array[$key], array_slice($keychain, 1));
}

function get($keychain, $default = null)
{
	return _get($GLOBALS['CONFIG'], $keychain, $default);
}
function _get($array, $keychain, $default)
{
	if(!is_array($keychain))
		$keychain = explode('.', $keychain);

	$key = $keychain[0];
	if(!isset($array[$key]))
		return $default;

	if(count($keychain) == 1)
		return $array[$key];

	return _get($array[$key], array_slice($keychain, 1), $default);
}

function startswith($needle, $haystack)
{
	return substr($haystack, 0, strlen($needle)) == $needle;
}
