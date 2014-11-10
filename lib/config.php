<?php
date_default_timezone_set('Europe/Berlin');

// guessed automatically
// $GLOBALS['CONFIG']['baseurl'] = 'http://foo.com/bar/';

$GLOBALS['CONFIG']['SCHEDULE'] = 'http://fahrplan.mrmcd.net/schedule.xml';
$GLOBALS['CONFIG']['SCHEDULE_CACHE_TTL'] = 5;
$GLOBALS['CONFIG']['SCHEDULE_SCALE'] = 0.2; // float, px per second
$GLOBALS['CONFIG']['SCHEDULE_OFFSET'] = strtotime('2014-11-09T17:00:00+01:00') - strtotime('2014-09-05T17:00:00+02:00');


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
	'hd' => 'FullHD',
	'hq' => 'High Quality',
	'lq' => 'Low Quality',
	'audio' => 'Audio',
	'slides' => 'Slide-Images',
);

// various room-name nappings
$GLOBALS['CONFIG']['FAHRPLAN_ROOM_MAPPING'] = array(
	'Grossbaustelle BER' => 'saal1',
	'Tiefbaustelle S21' => 'saal2',
	'Hochbaustelle Elbphilharmonie' => 'saal6',
);
