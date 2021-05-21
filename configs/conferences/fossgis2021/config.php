<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2021-06-07 08:00"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2021-06-09 18:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	//'CLOSED' => 'running',

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'FOSSGIS-Konferenz 2021',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'AUTHOR' => 'FOSSGIS e.V.',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
    'DESCRIPTION' => 'Die FOSSGIS-Konferenz ist die deutschsprachige Konferenz zu Open-Source-GIS und OpenStreetMap. Sie findet vom 6. bis 9. Juni 2021 in Rapperswil und im Netz statt.',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'FOSSGIS2021, OpenStreetMap, GIS, OpenSource, Geo',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		<a href="https://www.fossgis-konferenz.de/2021/">FOSSGIS-Konferenz 2021</a>
		by <a href="https://www.fossgis.de/">FOSSGIS e.V</a> &amp;
		<a href="https://c3voc.de">C3VOC</a>
	',

	/**
	 * HTML-Code für den Banner (nur auf der Startseite, direkt unter dem Header)
	 * wird üblicherweise für KeyVisuals oder Textmarke verwendet (vgl. Blaues
	 * Wischiwaschi auf http://media.ccc.de/)
	 *
	 * Dieser HTML-Block wird üblicherweise in der main.less speziell für die
	 * Konferenz umgestaltet.
	 *
	 * Wird diese Zeile auskommentiert, wird kein Banner ausgegeben.
	 */
/*	'BANNER_HTML' => '
		<img src="../configs/conferences/pw18/logo3.png">
	',
*/

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'https://media.ccc.de/c/fossgis2021',

	/**
	 * Um die interne ReLive-Ansicht zu aktivieren, kann hier ein ReLive-JSON
	 * konfiguriert werden. Üblicherweise wird diese Datei über das Script
	 * configs/download.sh heruntergeladen, welches von einem Cronjob
	 * regelmäßig getriggert wird.
	 *
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/fossgis20/index.json',
);

/**
 * Konfiguration der Stream-Übersicht auf der Startseite
 */
$CONFIG['OVERVIEW'] = array(
	/**
	 * Abschnitte auf der Startseite und darunter aufgeführte Räume
	 * Es können beliebig neue Gruppen und Räume hinzugefügt werden
	 *
	 * Die Räume müssen in $CONFIG['ROOMS'] konfiguriert werden,
	 * sonst werden sie nicht angezeigt.
	 */
	'GROUPS' => array(
		'Live' => array(
            'buehne1',
            'buehne2',
            'buehne3',
            'buehne4',
		),
	),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	'buehne1' => array(
		'DISPLAY' => 'Bühne 1',
		'STREAM' => 'fossgis1',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bühne 1',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#fossgis2021 @ twitter/mastodon',
			'TEXT'    => '#fossgis2021',
		),
	),
	'buehne2' => array(
		'DISPLAY' => 'Bühne 2',
		'STREAM' => 'fossgis2',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bühne 2',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#fossgis2021 @ twitter/mastodon',
			'TEXT'    => '#fossgis2021',
		),
	),
	'buehne3' => array(
		'DISPLAY' => 'Bühne 3',
		'STREAM' => 'fossgis3',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bühne 3',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#fossgis2021 @ twitter/mastodon',
			'TEXT'    => '#fossgis2021',
		),
	),
	'buehne4' => array(
		'DISPLAY' => 'Bühne 4',
		'STREAM' => 'fossgis4',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bühne 4',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#fossgis2021 @ twitter/mastodon',
			'TEXT'    => '#fossgis2021',
		),
	),
);



/**
 * Konfigurationen zum Konferenz-Fahrplan
 * Wird dieser Block auskommentiert, werden alle Fahrplan-Bezogenen Features deaktiviert
 */
$CONFIG['SCHEDULE'] = array(
	/**
	 * URL zum Fahrplan-XML
	 *
	 * Diese URL muss immer verfügbar sein, sonst könnte die Programm-Ansicht
	 * aufhören zu funktionieren. Üblicherweise wird diese daher Datei über
	 * das Script configs/download.sh heruntergeladen, welches von einem
	 * Cronjob regelmäßig getriggert wird.
	 */
	'URL' => 'https://pretalx.com/fossgis2021/schedule/export/schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert,: werden alle Räume angezeigt
	 */
	'ROOMFILTER' => array('Bühne 1', 'Bühne 2', 'Bühne 3', 'Bühne 4'),

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 4,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2016-12-29 auf den heutigen Tag 2016-02-24 verschoben ist.
	 */
	//'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2018-10-23 11:00') - strtotime(/* Today */ date('Y-m-d')),
	//'SIMULATE_OFFSET' => 0,
);


/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;

/**
 * Globale Konfiguration der Twitter-Links.
 *
 * Wird dieser Block auskommentiert, werden keine Twitter-Links mehr erzeugt. Sollen die
 * Twitter-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $CONFIG['TWITTER'] = true
 */
$CONFIG['TWITTER'] = true;

return $CONFIG;
