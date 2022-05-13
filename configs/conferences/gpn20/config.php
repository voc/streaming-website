<?php

$CONFIG['CONFERENCE'] = array(
    /**
     * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
     * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
     * und CLOSED weiter unten)
     */
    'STARTS_AT' => strtotime("2022-05-19 15:00"),

    /**
     * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
     * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
     */
    'ENDS_AT' => strtotime("2022-05-22 16:00"),

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
    'TITLE' => 'GPN20',

    /**
     * Veranstalter
     * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'AUTHOR' => 'CCC VOC & Entropia e.V.',

    /**
     * Beschreibungstext
     * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'DESCRIPTION' => 'Factory Reset',

    /**
     * Schlüsselwortliste, Kommasepariert
     * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'KEYWORDS' => 'GPN20, Gulaschprogrammiernacht, CCC, Karlsruhe, Livestream',

    /**
     * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
     * Sollte üblicherweise nur Inline-Elemente enthalten
     * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
     */
    'FOOTER_HTML' => '
		by <a href="https://c3voc.de">C3VOC</a> & <a href="https://entropia.de/GPN20">Entropia</a>
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
    'BANNER_HTML' => '<div class="gpn20"></div>',

    /**
     * Link zu den Recordings
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
    'RELEASES' => 'https://media.ccc.de/c/gpn20',

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
    'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/gpn20/index.json',

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
        'Vortragsräume' => array(
            'medientheater',
            'vortragssaal',
            'blauersalon'
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
    'medientheater' => array(
        'DISPLAY' => 'Medientheater',
        'WIDE' => true,
        'STREAM' => 's1',
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
        'SCHEDULE_NAME' => 'Medientheater',
        'FEEDBACK' => true,
        'SUBTITLES' => false,
        'EMBED' => true,
        'IRC' => false,
        'TWITTER' => true,
	),
    'vortragssaal' => array(
        'DISPLAY' => 'Vortragssaal',
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
        'SCHEDULE_NAME' => "Vortragssaal",
        'FEEDBACK' => true,
        'SUBTITLES' => false,
        'EMBED' => true,
        'IRC' => false,
        'TWITTER' => true,
	),
    'blauersalon' => array(
        'DISPLAY' => 'Blauer Salon',
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
        'SCHEDULE_NAME' => "Blauer Salon",
        'FEEDBACK' => true,
        'SUBTITLES' => false,
        'EMBED' => true,
        'IRC' => false,
        'TWITTER' => true,
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
    'URL' => 'https://cfp.gulas.ch/gpn20/schedule/export/schedule.xml',

    /**
     * Nur die angegebenen Räume aus dem Fahrplan beachten
     *
     * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
     */
    'ROOMFILTER' => ["Medientheater", "Vortragssaal", "Blauer Salon"],

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
    'DISPLAY' => '#gpn20 @ mastodon & twitter ',

    /**
     * Vorgabe-Tweet-Text für die Twitter-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
     */
    'TEXT' => '#gpn20',
);

$CONFIG['IRC'] = array(
    /**
     * Anzeigetext für die IRC-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
     * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
     */
    'DISPLAY' => '#gpn @ hackint',

    /**
     * URL für die IRC-Links.
     * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
     * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#32C3-%s'
     * verwendet werden.
     *
     * %s wird durch den urlencodeten Raum-Slug ersetzt.
     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
     */
    'URL' => 'https://webirc.hackint.org/#gpn',
);


return $CONFIG;
