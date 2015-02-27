<?php

require_once('lib/bootstrap.php');

$room = $_GET['room'];
$language = $_GET['language'];
$selection = $_GET['selection'];

switch($selection) {
	case 'audio':
		$type = 'audio';
		$title = 'Audio';
		break;

	case 'music':
		$type = 'audio';
		$title = 'Music';
		break;

	case 'slides':
		$type = 'slides';
		$title = 'Slides';
		break;

	case 'hd':
		$type = 'video';
		$title = 'FullHD Video';
		$width = 1920;
		$height = 1080;
		break;

	case 'sd':
		$type = 'video';
		$title = 'SD Video';
		$width = 1024;
		$height = 576;
		break;
}


$formats = get("ROOMS.$room.FORMATS");
$types = array();

if(count(array_intersect(array('rtmp-sd', 'rtmp-hd', 'hls-sd', 'hls-hd', 'webm-sd', 'webm-hd'), $formats)) > 0)
	$types[] = 'video';

if(count(array_intersect(array('audio-mp3', 'audio-opus'), $formats)) > 0)
	$types[] = 'audio';

if(count(array_intersect(array('slides'), $formats)) > 0)
	$types[] = 'slides';


echo $tpl->render(array(
	'page' => 'room',

	'title' => get("ROOMS.$room.DISPLAY").' – '.$title,
	'room' => $room,

	'program' => program(),

	'type' => $type,
	'types' => $types,

	'width' => @$width,
	'height' => @$height,
	'language' => $language,
	'translated' => ($language == 'translated'),
	'selection' => $selection,
	'hlsformat' => ($selection == 'hd' ? 'auto' : $selection),

	// miniroom = no translation, no slides, no irc, no program
	//   -> sendezentrum, workshops
	'miniroom' => in_array($room, array('sendezentrum')),
));
