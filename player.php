<?php

require_once('lib/PhpTemplate.php');
require_once('lib/helper.php');
require_once('config.php');

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

	case 'hq':
		$type = 'video';
		$width = 1920;
		$height = 1080;
		break;

	case 'hd':
		$type = 'video';
		$width = 1024;
		$height = 576;
		break;

	case 'ld':
		$type = 'video';
		$width = 640;
		$height = 360;
		break;
}

$tpl = new PhpTemplate('template/page.phtml');
echo $tpl->render(array(
	'page' => $type,
	'baseurl' => baseurl(),
	'title' => 'Rooms',

	'room' => $room,
	'roomname' => $GLOBALS['CONFIG']['ROOMS'][$room],

	'type' => $type,
	'width' => @$width,
	'height' => @$height,
));
