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

		return forceslash($base);
	}

	$base  = ssl() ? 'https://' : 'http://';
	$base .= $_SERVER['HTTP_HOST'];
	$base .=  forceslash(dirname($_SERVER['SCRIPT_NAME']));

	return forceslash($base);
}

function joinpath($parts)
{
	$parts = array_map('forceslash', $parts);
	return rtrim(implode('', $parts), '/');
}

function forceslash($url)
{
	$url =  rtrim($url, '/');
	if(strlen($url) > 0)
		$url .= '/';

	return $url;
}

function forceproto($url)
{
	if(startswith('//', $url))
		$url = proto().':'.$url;

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

function days_diff($date)
{
	$seconds = strtotime( $date ) - time();
	$days = intval(ceil($seconds / 60 / 60 / 24));
	return $days;
}

function days_diff_readable($date)
{
	$days = days_diff($date);
	if($days == -1)
		return 'yesterday';

	if($days == 0)
		return 'today';

	if($days == 1)
		return 'tomorrow';

	if($days < -60)
		return round(-$days / 30)." months ago";

	if($days < 0)
		return (-$days)." days ago";

	if($days > 60)
		return 'in '.round($days / 30)." months";

	return "in $days days";
}

function url_params()
{
	if($GLOBALS['forceopen'])
		return '?forceopen=yess';

	return '';
}

/**
 * returns the fielst element matching $predicate or null, if none matched.
 * $predicate is a callable that receives one array value at a time and can
 * return a bool'ish value
 */
function array_filter_first($array, $predicate)
{
	foreach ($array as $value) {
		if( $predicate($value) ) {
			return $value;
		}
	}

	return null;
}
/**
 * returns the fielst element matching $predicate or null, if none matched.
 * $predicate is a callable that receives one array value at a time and can
 * return a bool'ish value
 */
function array_filter_last($array, $predicate)
{
	foreach (array_reverse($array) as $value) {
		if( $predicate($value) ) {
			return $value;
		}
	}

	return null;
}
