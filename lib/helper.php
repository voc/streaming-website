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

		return forceslash(forceslash($base).@$GLOBALS['MANDATOR']);
	}

	$base  = ssl() ? 'https://' : 'http://';
	$base .= $_SERVER['HTTP_HOST'];
	$base .=  forceslash(dirname($_SERVER['SCRIPT_NAME']));

	return forceslash(forceslash($base).@$GLOBALS['MANDATOR']);
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

function handle_lesscss_request($lessfile, $relative_path)
{
	$dir = forceslash(sys_get_temp_dir());

	$css_file = Less_Cache::Get([
		$lessfile => $relative_path,
	], [
		'sourceMap' => true,
		'compress' => true,
		'relativeUrls' => true,

		'cache_dir' => $dir,
	]);

	$css = file_get_contents($dir.$css_file);
	header('Content-Type: text/css');
	header('Content-Length: '.strlen($css));
	print($css);
}
