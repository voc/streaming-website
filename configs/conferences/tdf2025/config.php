<?php

$CONFIG['CONFERENCE'] = array(
    'STARTS_AT' => strtotime("2025-07-26 11:00"),
    'ENDS_AT' => strtotime("2025-07-27 19:00"),
    'TITLE' => '4. Tübinger Tage der digitalen Freiheit',
    'AUTHOR' => 'Chaostreff Tübingen e.V. (CTT)',
    'FOOTER_HTML' => '
      by <a href="https://cttue.de/">Chaostreff Tübingen e.V. (CTT)</a>,
        <a href="https://chaoswest.tv">Chaos-West TV</a> &amp;
        <a href="https://c3voc.de">C3VOC</a>
      ',
    'RELEASES' => 'https://media.ccc.de/b/events/tdf/2025',
);

$CONFIG['OVERVIEW'] = array(
  'GROUPS' => array(
    'Lecture Rooms' => array(
      'stage1',
    ),
  ),
);

$CONFIG['ROOMS'] = array(
  'stage1' => array(
    'DISPLAY' => 'Bühne 1 (EG)',
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
    'SCHEDULE_NAME' => 'Bühne 1 (EG)',
    'FEEDBACK' => false,
    'SUBTITLES' => false,
    'EMBED' => true,
    'IRC' => false,
    'TWITTER' => false,
  ),
);

$CONFIG['EMBED'] = true;

$CONFIG['SCHEDULE'] = array(
	'URL' => 'https://cfp.cttue.de/tdf4/schedule/export/schedule.xml',
	'SCALE' => 7,
	'SIMULATE_OFFSET' => 0,
);

return $CONFIG;
