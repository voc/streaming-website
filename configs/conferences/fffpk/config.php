<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2020-10-13 09:45"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2020-10-13 11:15"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	/**'CLOSED' => 'after', */

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'Fridays for Future - Pressekonferenz',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'AUTHOR' => 'Fridays for Future',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'DESCRIPTION' => 'Pressekonferenz von Fridays for Future zur Machbarkeitsstudie.',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'Fridays for Future, Machbarkeitsstudie',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		<a href="https://fridaysforfuture.de/">fridaysforfuture.de</a>
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
	//'BANNER_HTML' => '',


	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	 #'RELEASES' => 'https://media.ccc.de/c/fusionpk',
	 

	/**
	 * Um die interne ReLive-Ansicht zu aktivieren, kann hier ein ReLive-JSON
	 * konfiguriert werden. Üblicherweise wird diese Datei über das Script
	 * configs/download.sh heruntergeladen, welches von einem Cronjob
	 * regelmäßig getriggert wird.
	 *
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELIVE_JSON' => 'https://live.ber.c3voc.de/relive/fffpk/index.json',
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
		'Live' => array(
			'fff',
		),
	),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	'fff' => array(
		'DISPLAY' => 'Pressekonferenz',
		'STREAM' => 'fff',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => false,
		'SCHEDULE_NAME' => 'q2',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#fff twitter/mastodon',
			'TEXT'    => '#fff',
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
	'URL' => 'https://cfp.privacyweek.at/pw18/schedule/export/schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
	'ROOMFILTER' => array('Saal 1', 'Saal 2', 'Workshop Raum'),

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 6,

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
$CONFIG['TWITTER'] = false;

return $CONFIG;
