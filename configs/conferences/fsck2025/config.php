<?php

$CONFIG['CONFERENCE'] = array(
    'STARTS_AT' => strtotime("2025-05-09 16:00"),
    'ENDS_AT' => strtotime("2025-05-11 19:00"),
    'TITLE' => 'FSCK 2025',
    'AUTHOR' => 'Chaostreff Backnang',
    'FOOTER_HTML' => '
      by <a href="https://ctbk.de/">Chaostreff Backnang</a>,
        <a href="https://chaoswest.tv">Chaos-West TV</a>,
        <a href="https://winkekatze.tv">Winkekatze.TV</a> &amp;
        <a href="https://c3voc.de">C3VOC</a>
      ',
    'RELEASES' => 'https://media.ccc.de/b/events/fsck/2025',
);

$CONFIG['OVERVIEW'] = array(
  'GROUPS' => array(
    'Lecture Rooms' => array(
      'kino5',
    ),
  ),
);

$CONFIG['ROOMS'] = array(
  'kino5' => array(
    'DISPLAY' => 'Kino 5',
    'STREAM' => 'fsck23',
    'PREVIEW' => true,
    'TRANSLATION' => false,
    'DASH' => true,
    'SD_VIDEO' => true,
    'HD_VIDEO' => true,
    'H264_ONLY' => true,
    'SLIDES' => false,
    'AUDIO' => true,
    'MUSIC' => false,
    'SCHEDULE' => true,
    'SCHEDULE_NAME' => 'Kino 5',
    'FEEDBACK' => false,
    'SUBTITLES' => false,
    'EMBED' => true,
    'IRC' => false,
    'TWITTER' => false,
  ),
);

$CONFIG['EMBED'] = true;

$CONFIG['SCHEDULE'] = array(
	'URL' => 'https://cfp.ctbk.de/fsck-2025/schedule/export/schedule.xml',
	'SCALE' => 7,
	'SIMULATE_OFFSET' => 0,
);

return $CONFIG;
