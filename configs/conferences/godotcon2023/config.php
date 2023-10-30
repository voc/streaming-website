<?php

$CONFIG['CONFERENCE'] = array(
	'STARTS_AT' => strtotime("2023-11-04 10:00"),
	'ENDS_AT' => strtotime("2023-11-05 19:00"),
	'TITLE' => 'GodotCon 2023',
	'AUTHOR' => 'Godot Foundation',
	'DESCRIPTION' => 'At GodotCon, we celebrate open source and game development through a series of inspiring talks and workshops. Over two days, learn from experts, share your experiences, and enjoy the company of fellow game developers.',
	'KEYWORDS' => 'GodotCon,Godot Engine,Godot,Game Development,Game Engine',
	'FOOTER_HTML' => '
		<a href="https://conference.godotengine.org/">GodotCon</a>: a <a href="https://godotengine.org/">Godot Engine</a> event.
	',
	'RELEASES' => 'https://media.ccc.de/c/godotcon2023',
	'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/godotcon2023/index.json',
);

$CONFIG['OVERVIEW'] = array(
	'GROUPS' => array(
		'Talks' => array(
			'redmond',
			'newyork'
		),
		'Atrium' +> array(
			'atrium'
		),
	),
);

$CONFIG['ROOMS'] = array(
	'redmond' => array(
		'DISPLAY' => 'Track 1',
		'STREAM' => 's2',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'H264_ONLY' => true,
		'DASH' => true,
		'AUDIO' => false,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Redmond',
		'FEEDBACK' => false,
		'EMBED' => true,
		'SUBTITLES' => false,
		'IRC' => true,
        	'IRC_CONFIG' => array(
            		'DISPLAY' => 'Webchat',
            		'URL' => 'Webchat URL',
         	),
         	'TWITTER' => true,
         	'TWITTER_CONFIG' => array(
             		'DISPLAY' => '#godotcon2023',
	 	 ),
	),

	'newyork' => array(
        	'DISPLAY' => 'Track 2',
         	'STREAM' => 's3',
         	'PREVIEW' => true,
         	'TRANSLATION' => false,
         	'SD_VIDEO' => true,
         	'HD_VIDEO' => true,
         	'H264_ONLY' => true,
         	'DASH' => true,
         	'AUDIO' => false,
         	'SLIDES' => false,
         	'MUSIC' => false,
         	'SCHEDULE' => true,
         	'SCHEDULE_NAME' => 'New York',
         	'FEEDBACK' => false,
         	'EMBED' => true,
         	'SUBTITLES' => false,
         	'IRC' => true,
         	'IRC_CONFIG' => array(
             		'DISPLAY' => 'Webchat',
             		'URL' => 'Webchat URL',
          	),
          	'TWITTER' => true,
          	'TWITTER_CONFIG' => array(
              		'DISPLAY' => '#godotcon2023',
          	),
     ),

	'atrium' => array(
		'WIDE' => true,
         	'DISPLAY' => 'Atrium',
         	'STREAM' => 's4',
         	'PREVIEW' => true,
         	'TRANSLATION' => false,
         	'SD_VIDEO' => true,
         	'HD_VIDEO' => true,
         	'H264_ONLY' => true,
         	'DASH' => true,
         	'AUDIO' => false,
         	'SLIDES' => false,
         	'MUSIC' => false,
         	'SCHEDULE' => true,
         	'SCHEDULE_NAME' => 'Atrium',
         	'FEEDBACK' => false,
         	'EMBED' => true,
         	'SUBTITLES' => false,
         	'IRC' => true,
         	'IRC_CONFIG' => array(
             		'DISPLAY' => 'Webchat',
             		'URL' => 'Webchat URL',
          	),
          	'TWITTER' => true,
          	'TWITTER_CONFIG' => array(
              		'DISPLAY' => '#godotcon2023',
          	),
     ),
);

$CONFIG['EMBED'] = true;
$CONFIG['IRC'] = array(
	'DISPLAY' => 'Webchat',
	'URL' => 'Webchat URL',
);

$CONFIG['TWITTER'] = array(
	'DISPLAY' => '#godotcon2023',
	'TEXT' => '#godotcon2023',
);

$CONFIG['SCHEDULE'] = array(
	'URL' => 'https://pretalx.c3voc.de/godotcon2023/schedule/export/schedule.xml',
	'ROOMFILTER' => array('Atrium', 'New York', 'Redmond'),
	'SCALE' => 7,
);

return $CONFIG;
