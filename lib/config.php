<?php
date_default_timezone_set('Europe/Berlin');

// guessed automatically
// $GLOBALS['CONFIG']['baseurl'] = 'http://foo.com/bar/';

$GLOBALS['CONFIG']['SCHEDULE'] = 'http://fahrplan.mrmcd.net/schedule.xml';
$GLOBALS['CONFIG']['SCHEDULE_CACHE_TTL'] = 5*60;
$GLOBALS['CONFIG']['SCHEDULE_SCALE'] = 0.2; // float, px per second

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

?>
