<?php

require_once('lib/bootstrap.php');


$room = $_GET['room'];
$language = $_GET['language'];
$selection = $_GET['selection'];

$formats = get("ROOMS.$room.FORMATS");
$has_translation = get("ROOMS.$room.TRANSLATION");

$protos = array();
$selections = array();
$tabs = array();
$videores = array();

if(room_has_hd($room))
	$selections[] = $videores[] = 'hd';

if(room_has_sd($room))
	$selections[] = $videores[] = 'sd';

if(room_has_video($room))
	$tabs[] = 'video';


if(room_has_audio($room))
	$selections[] = $tabs[] = 'audio';

if(room_has_music($room))
	$selections[] = $tabs[] = 'music';

if(room_has_slides($room))
	$selections[] = $tabs[] = 'slides';


if(room_has_rtmp($room))
	$protos[] = 'rtmp';

if(room_has_webm($room))
	$protos[] = 'webm';

if(room_has_hls($room))
	$protos[] = 'hls';



// default page
if(!$selection)
	$selection = $selections[0];

if(!in_array($selection, $selections))
	return include('404.php');



switch($selection) {
	case 'audio':
		$tab = 'audio';
		$title = 'Audio';
		break;

	case 'music':
		$tab = 'music';
		$title = 'Music';
		break;

	case 'slides':
		$tab = 'slides';
		$title = 'Slides';
		$width = 1024;
		$height = 576;
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
{
	if(!$has_translation)
		return include('404.php');

	$title = 'Translated '.$title;
}

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

	'has_translation' => $has_translation,
	'formats' => $formats,
	'protos' => $protos,
	'videores' => $videores,
));
