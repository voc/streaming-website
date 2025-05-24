<?php

$CONFIG['CONFERENCE'] = array(
    'STARTS_AT' => strtotime("2025-05-28 13:00"),
    'ENDS_AT' => strtotime("2025-05-31 19:00"),
    'TITLE' => 'Libre Graphics Meeting 2025',
    'AUTHOR' => 'Libre Graphics Meeting',
    'FOOTER_HTML' => '
      by <a href="https://https://libregraphicsmeeting.org/2025/">Libre Graphics Meeting</a>,
        <a href="https://chaoswest.tv">Chaos-West TV</a> &amp;
        <a href="https://c3voc.de">C3VOC</a>
      ',
    'RELEASES' => 'https://media.ccc.de/b/events/lgm/2025',
);

$CONFIG['OVERVIEW'] = array(
  'GROUPS' => array(
    'Lecture Rooms' => array(
      'main',
    ),
  ),
);

$CONFIG['ROOMS'] = array(
  'main' => array(
    'DISPLAY' => 'Main',
    'STREAM' => 'cwtv',
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
    'SCHEDULE_NAME' => 'main',
    'FEEDBACK' => false,
    'SUBTITLES' => false,
    'EMBED' => true,
    'IRC' => false,
    'TWITTER' => false,
  ),
);

$CONFIG['EMBED'] = true;

$CONFIG['SCHEDULE'] = array(
	'URL' => 'https://pretalx.c3voc.de/lgm25-upstream/schedule/export/schedule.xml',
	'SCALE' => 7,
	'SIMULATE_OFFSET' => 0,
);

return $CONFIG;
