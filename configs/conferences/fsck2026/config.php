<?php

$CONFIG["CONFERENCE"] = [
	"STARTS_AT" => strtotime("2026-05-08 16:00"),
	"ENDS_AT" => strtotime("2026-05-10 16:00"),
	"TITLE" => "FSCK 2026",
	"AUTHOR" => "Chaostreff Backnang",
	"FOOTER_HTML" => '
      by <a href="https://ctbk.de/">Chaostreff Backnang</a>,
        <a href="https://chaoswest.tv">Chaos-West TV</a>,
        <a href="https://winkekatze.tv">Winkekatze.TV</a> &amp;
        <a href="https://c3voc.de">C3VOC</a>
      ',
	"RELEASES" => "https://media.ccc.de/b/events/fsck/2026",
];

$CONFIG["OVERVIEW"] = [
	"GROUPS" => [
		"Lecture Rooms" => ["kino5"],
	],
];

$CONFIG["ROOMS"] = [
	"kino5" => [
		"DISPLAY" => "Kino 5",
		"STREAM" => "cwtv",
		"PREVIEW" => true,
		"TRANSLATION" => false,
		"DASH" => true,
		"SD_VIDEO" => true,
		"HD_VIDEO" => true,
		"H264_ONLY" => true,
		"SLIDES" => false,
		"AUDIO" => true,
		"MUSIC" => false,
		"SCHEDULE" => true,
		"SCHEDULE_NAME" => "Kino 5",
		"FEEDBACK" => false,
		"SUBTITLES" => false,
		"EMBED" => true,
		"IRC" => false,
		"TWITTER" => false,
	],
];

$CONFIG["EMBED"] = true;

$CONFIG["SCHEDULE"] = [
	"URL" => "https://cfp.ctbk.de/fsck-2026/schedule/export/schedule.xml",
	"SCALE" => 7,
	"SIMULATE_OFFSET" => 0,
];

return $CONFIG;
