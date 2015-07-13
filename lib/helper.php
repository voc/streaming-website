<?php

function ssl()
{
	return isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on');
}

function proto()
{
	return ssl() ? 'https' : 'http';
}

function baseurl()
{
	if(isset($GLOBALS['CONFIG']['BASEURL']))
	{
		$base = $GLOBALS['CONFIG']['BASEURL'];
		if(startswith('//', $base))
			$base = proto().':'.$base;

		return $base;
	}

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
