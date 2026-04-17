<?php

$CONFIG['CONFERENCE'] = array(
    /**
     * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
     * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
     * und CLOSED weiter unten)
     */
    'STARTS_AT' => strtotime("2022-07-22 16:30"),

    /**
     * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
     * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
     */
    'ENDS_AT' => strtotime("2022-07-26 17:00"),

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
  'TITLE' => 'MCH2022',

    /**
     * Veranstalter
     * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    // 'AUTHOR' => 'Havemann Gesellschaft Berlin',

    /**
     * Beschreibungstext
     * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
  'DESCRIPTION' => 'MCH2022',

    /**
     * Schlüsselwortliste, Kommasepariert
     * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    'KEYWORDS' => 'MCH, 2022, Hacker Camp',

    /**
     * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
     * Sollte üblicherweise nur Inline-Elemente enthalten
     * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
     */
    'FOOTER_HTML' => '
        by <a href="https://wiki.mch2022.org/Team:Productiehuis">MCH 2022 - Team Productiehuis</a> & <a href="https://c3voc.de">C3VOC</a>
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
    'BANNER_HTML' => "<h1 style=\"text-align: center;\"><img height=\"120\" src=\"../configs/conferences/mch2022/logo.png\"></h1>",

    /**
     * Link zu den Recordings
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
    'RELEASES' => 'https://media.ccc.de/c/MCH2022',

    /**
     * Um die interne ReLive-Ansicht zu aktivieren, kann hier ein ReLive-JSON
     * konfiguriert werden. Üblicherweise wird diese Datei über das Script
     * configs/download.sh heruntergeladen, welches von einem Cronjob
     * regelmäßig getriggert wird.
     *
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
     'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/mch2022/index.json',
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
      'Abacus',
      'Battery',
      'Clairvoyance',
	  'Musicstage',
	  'EmergentEarth',
	  'Muze'
    ),

    //'Live Music'  => array(
    //  'lounge',
    //),
  ),
);

/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
    /**
     * Array-Key ist der Raum-Slug, der z.B. auch zum erstellen der URLs,
     * in $CONFIG['OVERVIEW'] oder im Feedback verwendet wird.
     *
     * Der Raum-Slug darf ausschliesslich aus "unkritischen" Zeichen
     * ([a-zA-Z0-9_\-]) bestehen und insbesondere keine Leerzeichen
     * enthalten.
     */
    'Abacus' => array(
        'DISPLAY' => 'Abacus 🧮',
        'STREAM' => 's1',
        'PREVIEW' => true,
        'TRANSLATION' => false,
        'SD_VIDEO' => true,
        'HD_VIDEO' => true,
		'DASH' => true,
        'H264_ONLY' => true,
        'HLS' => true,
        'SLIDES' => false,
        'AUDIO' => true,
        'MUSIC' => false,
        'SCHEDULE' => true,
        'FEEDBACK' => true,
        'EMBED' => true,
		'TWITTER' => true,
		'IRC' => true
    ),
    'Battery' => array(
        'DISPLAY' => 'Battery 🔋',
        'STREAM' => 's2',
        'PREVIEW' => true,
        'TRANSLATION' => false,
        'SD_VIDEO' => true,
        'HD_VIDEO' => true,
		'DASH' => true,
        'H264_ONLY' => true,
		'HLS' => true,
        'SLIDES' => false,
        'AUDIO' => true,
        'MUSIC' => false,
        'SCHEDULE' => true,
        'FEEDBACK' => true,
        'EMBED' => true,
		'TWITTER' => true,
        'IRC' => true
	),
    'Clairvoyance' => array(
        'DISPLAY' => 'Clairvoyance 🔮',
        'STREAM' => 's3',
        'PREVIEW' => true,
        'TRANSLATION' => false,
        'SD_VIDEO' => true,
        'HD_VIDEO' => true,
		'DASH' => true,
        'H264_ONLY' => true,
		'HLS' => true,
        'SLIDES' => false,
        'AUDIO' => true,
        'MUSIC' => false,
        'SCHEDULE' => true,
        'FEEDBACK' => true,
		'EMBED' => true,
		'TWITTER' => true,
        'IRC' => true
    ),
    'Musicstage' => array(
        'DISPLAY' => 'Music Stage 🎤',
        'STREAM' => 'mch2022party',
        'PREVIEW' => true,
        'TRANSLATION' => false,
        'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
        'H264_ONLY' => true,
		'HLS' => true,
        'SLIDES' => false,
        'AUDIO' => true,
        'MUSIC' => false,
		'SCHEDULE' => true,
        'FEEDBACK' => true,
        'EMBED' => true,
		'TWITTER' => false,
		'IRC' => false
	),
	'EmergentEarth' => array(
		'DISPLAY' => 'Emergent Earth',
        'STREAM' => 's5',
        'PREVIEW' => true,
        'TRANSLATION' => false,
        'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
        'H264_ONLY' => true,
        'HLS' => true,
        'SLIDES' => false,
        'AUDIO' => true,
        'MUSIC' => false,
        'SCHEDULE' => true,
        'FEEDBACK' => true,
        'EMBED' => true,
		'TWITTER' => false,
		'IRC' => false
	),
	'Muze' => array(
        'DISPLAY' => 'HSNL/TkkrLab/Muze',
        'STREAM' => 'mch2022_muze',
        'PREVIEW' => true,
        'TRANSLATION' => false,
        'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
        'H264_ONLY' => true,
        'HLS' => true,
        'SLIDES' => false,
        'AUDIO' => true,
        'MUSIC' => false,
        'SCHEDULE' => true,
        'FEEDBACK' => true,
        'EMBED' => true,
        'TWITTER' => false,
        'IRC' => false
     ),
    'lounge' => array(
      'DISPLAY' => 'Lounge',
      'STREAM' => 'a1',
      'MUSIC' => true,
      'EMBED' => true,
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
    'URL' => 'https://program.mch2022.org/mch2021-2020/schedule/export/schedule.xml',

    /**
     * Nur die angegebenen Räume aus dem Fahrplan beachten
     *
     * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
     */
    'ROOMFILTER' => array('Abacus 🧮', 'Battery 🔋', 'Clairvoyance 🔮', 'Emergent Earth'),

    /**
     * Skalierung der Programm-Vorschau in Sekunden pro Pixel
     */
    'SCALE' => 7,

    /**
     * Simuliere das Verhalten als wäre die Konferenz bereits heute
     *
     * Diese folgende Beispiel-Zeile Simuliert, dass das
     * Konferenz-Datum 2016-12-29 auf den heutigen Tag 2016-02-24 verschoben ist.
     */
    //'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2016-12-27') - strtotime(/* Today */ date('Y-m-d')),
    //'SIMULATE_OFFSET' => 0,
);

$CONFIG['FEEDBACK'] = array(
    'DSN' => 'sqlite:/var/lib/streaming-feedback/feedback.sqlite3',
    'USERNAME' => 'katze',
    'PASSWORD' => trim(@file_get_contents('/var/lib/streaming-feedback/password')),
);

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;

/**
 * Konfiguration des L2S2-Systems
 * https://github.com/c3subtitles/L2S2
 *
 * Wird dieser Block auskommentiert, wird das gesamte Subtitle-System deaktiviert
 */
//$CONFIG['SUBTITLES'] = array(
//    /**
//     * URL des L2S2 Primus-Servers
//     */
//    'PRIMUS_URL' => 'https://live.c3subtitles.de/',
//
//    /**
//     * URL des L2S2 Frontend-Servers
//     */
//    'FRONTEND_URL' => 'https://live.c3subtitles.de/',
//);

/**
 * Globale Konfiguration der IRC-Links.
 *
 * Wird dieser Block auskommentiert, werden keine IRC-Links mehr erzeugt. Sollen die
 * IRC-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $CONFIG['IRC'] = true
 */
$CONFIG['IRC'] = array(
//    /**
//     * Anzeigetext für die IRC-Links.
//     *
//     * %s wird durch den Raum-Slug ersetzt.
//     * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
//     * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
//     */
    'DISPLAY' => '#mch2022-%s @ oftc',
//
//    /**
//     * URL für die IRC-Links.
//     * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
//     * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#33C3-%s'
//     * verwendet werden.
//     *
//     * %s wird durch den urlencodeten Raum-Slug ersetzt.
//     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
//     */
    'URL' => 'ircs://irc.oftc.net/mch2022-%s',
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
    'DISPLAY' => 'Twitter',

    /**
     * Vorgabe-Tweet-Text für die Twitter-Links.
     *
     * %s wird durch den Raum-Slug ersetzt.
     * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
     */
    'TEXT' => '#MCH2022',
);

return $CONFIG;
