<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2017-07-04 9:00"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2017-07-08 22:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	//'CLOSED' => true,

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'G20 Weltbild / World Feed',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'AUTHOR' => 'Berliner Modell',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'DESCRIPTION' => 'Weltbild (Host-TV): Die öffentlich-rechtlichen Rundfunkanstalten und privaten TV-Sender Deutschlands haben sie darauf geeinigt, im Zuge des sog. Berliner Modells gemeinsam ein Weltbild (Host-TV) zu erstellen. Es wird Entsprechend den u.g. Bedingungen des Berliner Modells über Satellit abgeben. Das Berliner Modell stellt das Weltbild kosten- und rechtefrei, auch für Onlinenutzung und zur Archivierung zur Verfügung. Mögliche Übertragungen vom Global Citizen Concert oder anderen Konzerten unterliegen allerdings rechtlichen Einschränkungen vonseiten der Künstler, die zur gegebenen Zeit mitgeteilt werden.',
         /**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'G20, Weltbild, NDR, Host TV',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		G20 Weltbild feeds provided by Berliner Modell,
                IP relay by <a href="https://c3voc.de">C3VOC</a>.
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
	//'BANNER_HTML' => '<img src="../configs/conferences/jh-hh-2017/Banner_JH-Hamburg-2017.svg" class="jhhh">',

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	//'RELEASES' => 'https://media.ccc.de/b/events/jugendhackt/2017',

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
	//'RELIVE_JSON' => 'configs/conferences/jh-hh-2017/vod.json',
	'RELIVE_JSON' => 'http://live.ber.c3voc.de/relive/weltbild1/index.json',

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
		'G20 Weltbild Channels' => array(
			'weltbild1',
//			'weltbild2',
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
	'weltbild1' => array(
		/**
		 * Angezeige-Name
		 */
		'DISPLAY' => 'G20 Weltbild / World Feed',
		'STREAM' => 'weltbild1',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'STEREO' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
	),
	'weltbild2' => array(
		/**
		 * Angezeige-Name
		 */
		'DISPLAY' => 'G20 Weltbild 2',
		'STREAM' => 'weltbild2',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'STEREO' => true,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => false,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => false,
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
	),
);

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;


return $CONFIG;
