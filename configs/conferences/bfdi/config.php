<?php

$CONFIG['CONFERENCE'] = array(
    /**
     * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
     * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
     * und CLOSED weiter unten)
     */
    'STARTS_AT' => strtotime("2022-05-04 19:00"),

    /**
     * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
     * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
     */
    'ENDS_AT' => strtotime("2022-05-05 21:30"),

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
    'TITLE' => 'Eröffnungsveranstaltung der Bonner Tage der Demokratie 2022 mit dem BfDI',

    /**
     * Veranstalter
     * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'AUTHOR' => 'Trio Service GmbH',

    /**
     * Beschreibungstext
     * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'DESCRIPTION' => 'Eröffnungsveranstaltung der Bonner Tage der Demokratie 2022 mit dem BfDI',

    /**
     * Schlüsselwortliste, Kommasepariert
     * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'KEYWORDS' => 'datenreichtum',

    /**
     * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
     * Sollte üblicherweise nur Inline-Elemente enthalten
     * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
     */
    'FOOTER_HTML' => '
		Event by <a href="https://www.trio-medien.de">Trio Service GmbH</a> | Streaming by <a href="https://c3voc.de">C3VOC</a>
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

    /**
     * Link zu den Recordings
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
    //'RELEASES' => 'https://media.ccc.de/c/glt22',

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
    //'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/glt22/index.json'

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
            'bfdi',
        ),
    ),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	'bfdi' => array(
		'DISPLAY' => 'Eröffnungsveranstaltung',
		'STREAM' => 'bfdi',
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

		'SCHEDULE' => false,
		'SCHEDULE_NAME' => 'HS i1',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#glt22 @ twitter/mastodon',
			'TEXT'    => '#glt22',
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

/**
 * Globale Konfiguration der Twitter-Links.
 *
 * Wird dieser Block auskommentiert, werden keine Twitter-Links mehr erzeugt. Sollen die
 * Twitter-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $CONFIG['TWITTER'] = true
 */

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
