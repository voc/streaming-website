<?php

require_once('lib/bootstrap.php');

$room = $_GET['room'];
$language = $_GET['language'];
$format = $_GET['format'];

switch($format) {
	case 'audio':
		$type = 'audio';
		break;

	case 'slides':
		$type = 'slides';
		break;

	case 'hd':
		$type = 'video';
		$width = 1920;
		$height = 1080;
		break;

	case 'hq':
		$type = 'video';
		$width = 1024;
		$height = 576;
		break;

	case 'lq':
		$type = 'video';
		$width = 640;
		$height = 360;
		break;
}

echo $tpl->render(array(
	'page' => 'room',

	'title' => $GLOBALS['CONFIG']['ROOMS'][$room].' – '.$GLOBALS['CONFIG']['FORMATS'][$format],

	'rooms' => $GLOBALS['CONFIG']['ROOMS'],
	'formats' => $GLOBALS['CONFIG']['FORMATS'],

	'room' => $room,
	'roomname' => $GLOBALS['CONFIG']['ROOMS'][$room],

	'program' => program(),

	'type' => $type,
	'width' => @$width,
	'height' => @$height,
	'language' => $language,
	'translated' => ($language == 'translated'),
	'format' => $format,

	// miniroom = no hd, no translation, no slides, no irc, no program
	//   -> sendezentrum, workshops
	'miniroom' => in_array($room, array('sendezentrum')=,
));
