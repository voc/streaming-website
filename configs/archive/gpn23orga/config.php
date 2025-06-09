<?php

$CONFIG['CONFERENCE'] = array(
	'STARTS_AT' => strtotime("2025-04-12 13:37"),
	'ENDS_AT' => strtotime("2025-04-12 23:42"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	// 'CLOSED' => "running",
	'TITLE' => 'GPN23 – Einführungsveranstaltung in die Orga',
	'AUTHOR' => 'Entropia e.V.',
	'DESCRIPTION' => 'Einführungsveranstaltung in die Orga der 23. Gulaschprogrammiernacht',
	'KEYWORDS' => 'gpn, gpn23, gpn-orga',
	'FOOTER_HTML' => '
		<a href="https://entropia.de/">Entropia</a> – <a href="https://entropia.de/GPN23:Orga-Einfuehrungsverastaltung">Einführungsveranstaltung in die Orga</a> |
        Video by <a href="https://winkekatze.tv">Winkekatze.TV</a> |
        Streaming by <a href="https://c3voc.de">C3VOC</a>
	',
);
$CONFIG['OVERVIEW'] = array(
	'GROUPS' => array(
		'Entropia' => array(
			'Einfuehrungsveranstaltung',
		),
	),
);

$CONFIG['ROOMS'] = array(
	'Einfuehrungsveranstaltung' => array(
		'Display' => 'GPN23 – Einführungsveranstaltung in die Orga',
		'STREAM' => 'entropia',
		'PREVIEW' => true,
		'TRANSLATION' => true,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
);

$CONFIG['EMBED'] = true;

return $CONFIG;
