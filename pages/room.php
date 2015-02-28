<?php

require_once('lib/bootstrap.php');


$room = $_GET['room'];
$language = $_GET['language'];
$selection = $_GET['selection'];

$formats = get("ROOMS.$room.FORMATS");

$selections = array();
$tabs = array();


if(count(array_intersect(array('rtmp-hd', 'hls-hd', 'webm-hd'), $formats)) > 0)
	$selections[] = 'hd';

if(count(array_intersect(array('rtmp-sd', 'hls-sd', 'webm-sd'), $formats)) > 0)
	$selections[] = 'sd';

if(count(array_intersect(array('rtmp-sd', 'rtmp-hd', 'hls-sd', 'hls-hd', 'webm-sd', 'webm-hd'), $formats)) > 0)
	$tabs[] = 'video';

if(count(array_intersect(array('audio-mp3', 'audio-opus'), $formats)) > 0)
	$selections[] = $tabs[] = 'audio';

if(count(array_intersect(array('slides'), $formats)) > 0)
	$selections[] = $tabs[] = 'slides';


// default page
if(!$selection)
	$selection = $selections[0];

if(!in_array($selection, $selections)) {
	include('404.php');
	exit;
}


switch($selection) {
	case 'audio':
		$tab = 'audio';
		$title = 'Audio';
		break;

	case 'music':
		$tab = 'audio';
		$title = 'Music';
		break;

	case 'slides':
		$tab = 'slides';
		$title = 'Slides';
		break;

	case 'hd':
		$tab = 'video';
		$title = 'FullHD Video';
		$width = 1920;
		$height = 1080;
		break;

	case 'sd':
		$tab = 'video';
		$title = 'SD Video';
		$width = 1024;
		$height = 576;
		break;
}

if($language == 'translated')
	$title = 'Translated '.$title;

echo $tpl->render(array(
	'page' => 'room',

	'title' => get("ROOMS.$room.DISPLAY").' – '.$title,
	'room' => $room,

	'program' => program(),

	'tab' => $tab,
	'tabs' => $tabs,

	'width' => @$width,
	'height' => @$height,
	'language' => $language,
	'translated' => ($language == 'translated'),
	'selection' => $selection,
	'hlsformat' => ($selection == 'hd' ? 'auto' : $selection),
	'formats' => $formats,
));
