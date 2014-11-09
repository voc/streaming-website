<?php

require_once('program.php');

function link_index()
{
	return '';
}

function link_room($room)
{
	return rawurlencode($room).'/';
}

function link_player($room, $format, $translated = false)
{
	$isDefaultFormat = in_array($format, array('hq', 'video'));

	return rawurlencode($room).'/'.($isDefaultFormat ? '' : rawurlencode($format).'/').($translated ? 'translated/' : '');
}

function link_stream($protocol, $room, $format, $translated = false)
{
	$language = $translated ? 'translated' : 'native';

	switch ($protocol) {
		case 'rtmp':
			return 'rtmp://rtmp.streaming.media.ccc.de:1935/stream/'.rawurlencode($room).'_'.rawurlencode($language).'_'.rawurlencode($format);

		case 'hls':
			return 'http://hls.streaming.media.ccc.de/hls/'.rawurlencode($room).'_'.rawurlencode($language).'_'.rawurlencode($format).'.m3u8';

		case 'icecast':
			return 'http://webm.streaming.media.ccc.de:8000/'.rawurlencode($room).'_'.rawurlencode($language).'.'.rawurlencode($format);

		case 'slide':
			return 'http://localhost/~peter/slide-stream-test/'.rawurlencode($room).'/current.png';
	}

	return '#';
}

function baseurl()
{
	if(isset($GLOBALS['CONFIG']['baseurl']))
		return $GLOBALS['CONFIG']['baseurl'];

	$base  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://';
	$base .= $_SERVER['HTTP_HOST'];
	$base .=  rtrim(dirname($_SERVER['SCRIPT_NAME']), '/').'/';

	return $base;
}

function strtoduration($str)
{
	$parts = explode(':', $str);
	return ((int)$parts[0] * 60 + (int)$parts[1]) * 60;
}
