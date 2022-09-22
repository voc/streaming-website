<?php

$CONFIG['CONFERENCE'] = array(
	'STARTS_AT' => strtotime("2022-10-04 08:30 CDT"),
	'ENDS_AT' => strtotime("2022-10-06 17:30 CDT"),
	//'CLOSED' => 'running',

	'TITLE' => 'XDC + WineConf + FOSS XR 2022',
	'AUTHOR' => 'X.Org Foundation',
	'DESCRIPTION' => 'The X.Org Developers Conference + WineConf + FOSS XR',
	'KEYWORDS' => 'x.org, xorg, xdc, graphics, wine, wineconf, foss, xr',
	'FOOTER_HTML' => '
		<a href="https://xdc2022.x.org">XDC 2022</a> &middot; <a href="https://x.org">X.org Foundation</a> &middot; hosted by <a href="https://c3voc.de">C3VOC</a>
	',
);

$CONFIG['OVERVIEW'] = array(
	'GROUPS' => array(
		'Lecture Rooms' => array(
			'xdc22',
			'wineconf22',
			'fossxr22',
		),
	),
);

$CONFIG['ROOMS'] = array(
	'xdc22' => array(
		'DISPLAY' => 'XDC',
		'STREAM' => 'xdc22',
		'PREVIEW' => true,
		'TRANSLATION' => false,

		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,

		'AUDIO' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'XDC 2022',

		'FEEDBACK' => false,
		'SUBTITLES' => false,

		'EMBED' => true,

		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#xdc-wineconf-fossxr-2022:matrix.org',
			'URL'     => 'https://matrix.to/#/#xdc-wineconf-fossxr-2022:matrix.org?via=matrix.org',
		),

		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#XOrgDevConf @ Twitter',
			'TEXT'    => '#XOrgDevConf',
		),
	),

	'wineconf22' => array(
		'DISPLAY' => 'WineConf',
		'STREAM' => 'wineconf22',
		'PREVIEW' => true,
		'TRANSLATION' => false,

		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,

		'AUDIO' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'WineConf 2022',

		'FEEDBACK' => false,
		'SUBTITLES' => false,

		'EMBED' => true,

		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#xdc-wineconf-fossxr-2022:matrix.org',
			'URL'     => 'https://matrix.to/#/#xdc-wineconf-fossxr-2022:matrix.org?via=matrix.org',
		),

		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#XOrgDevConf @ Twitter',
			'TEXT'    => '#XOrgDevConf',
		),
	),

	'fossxr22' => array(
		'DISPLAY' => 'FOSS XR',
		'STREAM' => 'fossxr22',
		'PREVIEW' => true,
		'TRANSLATION' => false,

		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,

		'AUDIO' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'FOSS XR 2022',

		'FEEDBACK' => false,
		'SUBTITLES' => false,

		'EMBED' => true,

		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#xdc-wineconf-fossxr-2022:matrix.org',
			'URL'     => 'https://matrix.to/#/#xdc-wineconf-fossxr-2022:matrix.org?via=matrix.org',
		),

		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#fossxr @ Twitter',
			'TEXT'    => '#fossxr',
		),
	),
);

$CONFIG['EMBED'] = true;

$CONFIG['SCHEDULE'] = array(
	'URL' => 'https://hiler.eu/xdc22/schedule.xml',
	'ROOMFILTER' => [
        'XDC 2022',
        'WineConf 2022',
        'FOSS XR 2022',
	],
	'SCALE' => 7,
	'SIMULATE_OFFSET' => 0,
);

$CONFIG['TWITTER'] = true;
$CONFIG['IRC'] = true;


return $CONFIG;
