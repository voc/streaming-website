<?php

$CONFIG['CONFERENCE'] = array(
    /**
     * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
     * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
     * und CLOSED weiter unten)
     */
    'STARTS_AT' => strtotime("2024-04-05 08:00"),

    /**
     * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
     * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
     */
    'ENDS_AT' => strtotime("2024-04-06 19:30"),

    /**
     * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
     * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
     * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
     *
     * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
     * zu 'running'.
     */
    //'CLOSED' => false,

    /**
     * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
     * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
     * Anzeigetext benutzt
     */
    'TITLE' => 'Grazer Linuxtage 2024',

    /**
     * Veranstalter
     * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'AUTHOR' => 'Verein zur Förderung freier Soft- und Hardware',

    /**
     * Beschreibungstext
     * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'DESCRIPTION' => 'Grazer Linuxtage 2024',

    /**
     * Schlüsselwortliste, Kommasepariert
     * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'KEYWORDS' => 'Linuxtage, Linux, 2024, Video, Media, Streaming, Graz',

    /**
     * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
     * Sollte üblicherweise nur Inline-Elemente enthalten
     * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
     */
    'FOOTER_HTML' => '
		by <a href="https://c3voc.de">C3VOC</a>
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
    'BANNER_HTML' => '<div class="glt24"></div>',

    /**
     * Link zu den Recordings
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
    'RELEASES' => 'https://media.ccc.de/c/glt24',

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
    'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/glt24/index.json'

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
        'Vortragsraeume' => array(
            'i1',
            'i2',
            'i7',
        ),
    ),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	'i1' => array(
		'DISPLAY' => 'HS i1',
		'STREAM' => 's2',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'HS i1',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#glt24 @ mastodon',
			'TEXT'    => '#glt24',
		),
	),
	'i2' => array(
		'DISPLAY' => 'HS i2',
		'STREAM' => 's3',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'HS i2',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#glt24 @ mastodon',
			'TEXT'    => '#glt24',
		),
	),
	'i7' => array(
		'DISPLAY' => 'HS i7',
		'STREAM' => 's5',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'HS i7',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#glt24 @ mastodon',
			'TEXT'    => '#glt24',
		),
	),
    
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
     */
    'URL' => 'https://pretalx.linuxtage.at/glt24/schedule/export/schedule.xml',

    /**
     * Nur die angegebenen Räume aus dem Fahrplan beachten
     *
     * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
     */
    'ROOMFILTER' => ['HS i1', 'HS i2', 'HS i7'],

    /**
     * Skalierung der Programm-Vorschau in Sekunden pro Pixel
     */
    'SCALE' => 5,

    /**
     * Simuliere das Verhalten als wäre die Konferenz bereits heute
     *
     * Diese folgende Beispiel-Zeile Simuliert, dass das
     * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
     */
    //SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2018-03-30') - strtotime(/* Today */ date('Y-m-d')))
    'SIMULATE_OFFSET' => 0,
);

/**
 * Globale Konfiguration der Twitter-Links.
 *
 * Wird dieser Block auskommentiert, werden keine Twitter-Links mehr erzeugt. Sollen die
 * Twitter-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $CONFIG['TWITTER'] = true
 */
$CONFIG['TWITTER'] = array(
    /**
     * Anzeigetext für die Twitter-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Ist eine weitere Anpassung erfoderlich, kann ein TWITTER_CONFIG-Block in der
     * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
     */
    'DISPLAY' => '#glt24 @ Mastodon',

    /**
     * Vorgabe-Tweet-Text für die Twitter-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
     */
    'TEXT' => '@linuxtage@graz.social #glt24',
);

$CONFIG['IRC'] = array(
    /**
     * Anzeigetext für die IRC-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
     * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
     */
    'DISPLAY' => '',

    /**
     * URL für die IRC-Links.
     * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
     * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#32C3-%s'
     * verwendet werden.
     *
     * %s wird durch den urlencodeten Raum-Slug ersetzt.
     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
     */
    'URL' => '',
);


return $CONFIG;
