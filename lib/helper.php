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

function startswith($needle, $haystack)
{
	return substr($haystack, 0, strlen($needle)) == $needle;
}
