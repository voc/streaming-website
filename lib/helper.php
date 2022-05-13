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

function slugify($text)
{
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// trim
	$text = trim($text, '-');

	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);

	// lowercase
	$text = strtolower($text);

	if (empty($text)) {
		return 'none';
	}

	return $text;
}

function do_download($url, $cache, $return_response = false)
{
	$handle = curl_init($url);
	curl_setopt_array($handle, [
		CURLOPT_FOLLOWLOCATION  => true,
		CURLOPT_MAXREDIRS       => 10,
		CURLOPT_RETURNTRANSFER  => true,
		CURLOPT_SSL_VERIFYPEER  => false, /* accept all certificates, even self-signed */
		CURLOPT_SSL_VERIFYHOST  => 2,     /* verify hostname is in cert */
		CURLOPT_CONNECTTIMEOUT  => 3,     /* connect-timeout in seconds */
		CURLOPT_TIMEOUT         => 5,     /* transfer timeout im seconds */
		CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
		CURLOPT_USERAGENT       => '@c3voc Streaming-Website Downloader-Cronjob, Contact voc AT c3voc DOT de in case of problems. Might the Winkekatze be with you',
	]);

	$return = curl_exec($handle);
	$info = curl_getinfo($handle);
	curl_close($handle);

	// TODO: should we add proper exceptions?
	if($info['http_code'] != 200)
		return 'http-code = '.$info['http_code'];

	$tempfile = tempnam(dirname($cache), 'dl-');
	if(!$tempfile)
		return 'could not create tempfile in '.dirname($cache);

	if(false === file_put_contents($tempfile, $return))
		return 'could write data into tempfile '.$tempfile;

	chmod($tempfile, 0644);
	rename($tempfile, $cache);

	return $return_response ? $return : true;
}


// specifies the number of seconds after which data will be refreshed
static $cache_lifetime	= 300; // 5min
$check_time = time() - $cache_lifetime;

function query_data($operation, $query, $variables = [], $assoc = false, $cache = null) {
	global $check_time;

	$cache = $cache ?: joinpath([$GLOBALS['BASEDIR'], 'cache', $operation, http_build_query($variables) . '.json']);

	if (file_exists($cache) && filemtime($cache) > $check_time) {
		$res = file_get_contents($cache);
	} else {
		$url = 'https://data.c3voc.de/graphql?variables=' .json_encode($variables) . '&query=' . urlencode(preg_replace('/\s\s+/', ' ', $query));
		$res = do_download($url, $cache, true);
	}
	$r = json_decode($res, $assoc);

	if (is_null($r)) {
		throw new NotFoundException();
	}

	// TODO: add error handling?
	// TODO: should we return the cached value, when we did not get an answer? 
	return $assoc ? @$r['data'] : @$r->data;
}