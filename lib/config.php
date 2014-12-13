<?php
date_default_timezone_set('Europe/Berlin');

// guessed automatically
// $GLOBALS['CONFIG']['baseurl'] = 'http://foo.com/bar/';

$GLOBALS['CONFIG']['SCHEDULE'] = 'http://events.ccc.de/congress/2014/Fahrplan/schedule.xml';
$GLOBALS['CONFIG']['SCHEDULE_SCALE'] = 0.2; // float, px per second
$GLOBALS['CONFIG']['SCHEDULE_OFFSET'] = 0;


$GLOBALS['CONFIG']['ROOMS'] = array(
	'saal1' => 'Saal 1',
	'saal2' => 'Saal 2',
	'saalg' => 'Saal G',
	'saal6' => 'Saal 6',

	'lounge' => 'Lounge',
	'ambient' => 'Ambient',

	'sendezentrum' => 'Sendezentrum',
);

$GLOBALS['CONFIG']['FORMATS'] = array(
	'hd' => 'FullHD Video',
	'sd' => 'SD Video',
	'audio' => 'Audio',
	'slides' => 'Slide-Images',
);

$GLOBALS['CONFIG']['FORMAT_TEXT'] = array(
	'hd' =>   '1920x1080, h264+aac, 3 MBit/s',
	'sd' =>   '1024x576, h264+aac, 1 MBit/s',
	'webm' => '1024x576 vp8+vorbis in webm, 1 MBit/s',

	'mp3' =>  'MP3, 128 kBit/s',
	'opus' => 'Opus (RFC 6716), 96 kBit/s',

	'party-mp3' =>  'MP3, 320 kBit/s',
	'party-opus' => 'Opus (RFC 6716), 128 kBit/s',
);

// various room-name nappings
$GLOBALS['CONFIG']['FAHRPLAN_ROOM_MAPPING'] = array(
	'Saal 1' => 'saal1',
	'Saal 2' => 'saal2',
	'Saal G' => 'saalg',
	'Saal 6' => 'saal6',
);
