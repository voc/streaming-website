<?php

function ssl()
{
	return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'];
}

function proto()
{
	return ssl() ? 'https' : 'http';
}

function baseurl()
{
	if(isset($GLOBALS['CONFIG']['BASEURL']))
		return $GLOBALS['CONFIG']['BASEURL'];

	$base  = ssl() ? 'https://' : 'http://';
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

function startswith($needle, $haystack)
{
	return substr($haystack, 0, strlen($needle)) == $needle;
}
