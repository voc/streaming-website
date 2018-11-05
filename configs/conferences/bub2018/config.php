<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2018-11-17 10:00"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2018-11-18 18:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
//	'CLOSED' => 'running',

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'Bits & Bäume',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
  'AUTHOR' => 'Bits & Bäume',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
  'DESCRIPTION' => 'Die Konferenz für Digitalisierung und Nachhaltigkeit 17. bis 18. November 2018 in Berlin (Technische Universität)',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'Bits und Bäume, FIfF, CCC, Nachhaltigkeit, Digitalisierung',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		by <a href="https://bits-und-baeume.org">Bits & Bäume</a>
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
	/** 'BANNER_HTML' => '<img src="../configs/conferences/fiffkon16/logo.png" class="FIfFKon">', **/

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'https://media.ccc.de/c/bub2018',

	/**
	 * Link zu einer (externen) ReLive-Übersichts-Seite
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	//'RELIVE' => 'http://vod.c3voc.de/',

	/**
	 * Alternativ kann ein ReLive-Json konfiguriert werden, um die interne
	 * ReLive-Ansicht zu aktivieren.
	 *
	 * Wird beides aktiviert, hat der externe Link Vorrang!
	 * Wird beides auskommentiert, wird der Link nicht angezeigt
	 */
	 'RELIVE_JSON' => 'http://live.ber.c3voc.de/relive/bub2018/index.json'
	/**
	 * APCU-Cache-Zeit in Sekunden
	 * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
	 * das Relive-Json bei jedem Request von der Quelle geladen und geparst
	 */
	//'RELIVE_JSON_CACHE' => 30*60,
);

/**
 * Konfiguration der Stream-Übersicht auf der Startseite
 */
$CONFIG['OVERVIEW'] = array(
	/**
	 * Abschnitte aud der Startseite und darunter aufgeführte Räume
	 * Es können beliebig neue Gruppen und Räume hinzugefügt werden
	 *
	 * Die Räume müssen in $CONFIG['ROOMS'] konfiguriert werden,
	 * sonst werden sie nicht angezeigt.
	 */
	'GROUPS' => array(
		'Lecture Rooms' => array(
			'Saal1',
			'Saal2',
			'Saal3',
			'Saal4',
			'Saal5'
		),
	),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	/**
	 * Array-Key ist der Raum-Slug, der z.B. auch zum erstellen der URLs,
	 * in $CONFIG['OVERVIEW'] oder im Feedback verwendet wird.
	 */
	'Saal1' => array(
                'DISPLAY' => 'MA 001',
                'STREAM' => 's1',
                'PREVIEW' => true,
                'TRANSLATION' => false,
                'STEREO' => false,

                'SD_VIDEO' => true,
                'HD_VIDEO' => true,
                'SLIDES' => false,
                'DASH' => true,

                'AUDIO' => true,
                'MUSIC' => false,

                'SCHEDULE' => true,
                'SCHEDULE_NAME' => 'MA 001',

                'FEEDBACK' => false,
                'SUBTITLES' => false,

                'EMBED' => true,
                'IRC' => false,
	),
        'Saal2' => array(
		'DISPLAY' => 'MA 001',
                'STREAM' => 's2',
                'PREVIEW' => true,
                'TRANSLATION' => false,
                'STEREO' => false,

                'SD_VIDEO' => true,
                'HD_VIDEO' => true,
                'SLIDES' => false,
                'DASH' => true,

                'AUDIO' => true,
                'MUSIC' => false,

                'SCHEDULE' => true,
                'SCHEDULE_NAME' => 'MA 001',

                'FEEDBACK' => false,
                'SUBTITLES' => false,

                'EMBED' => true,
                'IRC' => false,
        ),
        'Saal3' => array(
                'DISPLAY' => 'MA 001',
                'STREAM' => 's3',
                'PREVIEW' => true,
                'TRANSLATION' => false,
                'STEREO' => false,

                'SD_VIDEO' => true,
                'HD_VIDEO' => true,
                'SLIDES' => false,
                'DASH' => true,

                'AUDIO' => true,
                'MUSIC' => false,

                'SCHEDULE' => true,
                'SCHEDULE_NAME' => 'MA 001',

                'FEEDBACK' => false,
                'SUBTITLES' => false,

                'EMBED' => true,
                'IRC' => false,
        ),
        'Saal4' => array(
                'DISPLAY' => 'MA 001',
                'STREAM' => 's4',
                'PREVIEW' => true,
                'TRANSLATION' => false,
                'STEREO' => false,

                'SD_VIDEO' => true,
                'HD_VIDEO' => true,
                'SLIDES' => false,
                'DASH' => true,

                'AUDIO' => true,
                'MUSIC' => false,

                'SCHEDULE' => true,
                'SCHEDULE_NAME' => 'MA 001',

                'FEEDBACK' => false,
                'SUBTITLES' => false,

                'EMBED' => true,
                'IRC' => false,
        ),
        'Saal5' => array(
                'DISPLAY' => 'HE 101',
                'STREAM' => 's5',
                'PREVIEW' => true,
                'TRANSLATION' => false,
                'STEREO' => false,

                'SD_VIDEO' => true,
                'HD_VIDEO' => true,
                'SLIDES' => false,
                'DASH' => true,

                'AUDIO' => true,
                'MUSIC' => false,

                'SCHEDULE' => true,
                'SCHEDULE_NAME' => 'HE 101',

                'FEEDBACK' => false,
		'SUBTITLES' => false,
	)
);

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;

/**
 * Konfigurationen zum Konferenz-Fahrplan
 * Wird dieser Block auskommentiert, werden alle Fahrplan-Bezogenen Features deaktiviert
 */
$CONFIG['SCHEDULE'] = array(
	/**
	 * URL zum Fahrplan-XML
	 *
	 * Diese URL muss immer verfügbar sein, sonst können kann die Programm-Ansicht
	 * aufhören zu funktionieren. Wenn die Quelle unverlässlich ist ;) sollte ein
	 * externer HTTP-Cache vorgeschaltet werden.
	 */
	'URL' => 'https://fahrplan.bits-und-baeume.org/schedule.xml',

        /**
         * Nur die angegebenen Räume aus dem Fahrplan beachten
         *
         * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
         */
        'ROOMFILTER' => array('HE 101', 'MA 001'),

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 7,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
	 */
	//'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2016-05-21') - strtotime(/* Today */ '2016-05-19'),
	'SIMULATE_OFFSET' => 0,
);


return $CONFIG;
