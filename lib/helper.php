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

function link_player($room, $format = 'sd', $translated = false)
{
	$isDefaultFormat = in_array($format, array('sd', 'video'));

	return rawurlencode($room).'/'.($isDefaultFormat ? '' : rawurlencode($format).'/').($translated ? 'translated/' : '');
}

function link_stream($protocol, $room, $format, $translated = false)
{
	$language = $translated ? 'translated' : 'native';

	switch ($protocol) {
		case 'rtmp':
			return 'rtmp://rtmp.stream.c3voc.de:1935/stream/'.rawurlencode(streamname($room)).'_'.rawurlencode($language).'_'.rawurlencode($format);

		case 'hls':
			return 'http://hls.stream.c3voc.de/hls/'.rawurlencode(streamname($room)).'_'.rawurlencode($language).($format == 'auto' ? '' : '_'.rawurlencode($format)).'.m3u8';

		case 'webm':
			return 'http://webm.stream.c3voc.de:8000/'.rawurlencode(streamname($room)).'_'.rawurlencode($language).'_'.rawurlencode($format).'.webm';

		case 'audio':
			if(in_array($room, array('lounge', 'ambient')))
				return 'http://audio.stream.c3voc.de:8000/'.rawurlencode(streamname($room)).'.'.rawurlencode($format);
			else
				return 'http://audio.stream.c3voc.de:8000/'.rawurlencode(streamname($room)).'_'.rawurlencode($language).'.'.rawurlencode($format);

		case 'slide':
			return 'http://www.stream.c3voc.de/slides/'.rawurlencode(streamname($room)).'/current.png';
	}

	return '#';
}

function link_vod($id)
{
	return 'relive/'.rawurlencode($id).'/';
}

function streamname($room)
{
	switch($room)
	{
		case 'saal1': return 's1';
		case 'saal2': return 's2';
		case 'saalg': return 's3';
		case 'saal6': return 's4';
		case 'sendezentrum': return 's5';
		default: return $room;
	}
}

function irc_channel($room)
{
	return '31C3-hall-'.strtoupper(substr($room, 4, 1));
}

function twitter_hashtag($room)
{
	return '#hall'.strtoupper(substr($room, 4, 1));
}

function format_text($format)
{
	return @$GLOBALS['CONFIG']['FORMAT_TEXT'][$format] ?: '';
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
