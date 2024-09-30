<?php

$CONFIG["CONFERENCE"] = [
    /**
     * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
     * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
     * und CLOSED weiter unten)
     */
    "STARTS_AT" => strtotime("2024-10-03 13:00"),

    /**
     * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
     * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
     *
     * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
     */
    "ENDS_AT" => strtotime("2024-10-06 18:00"),

    /**
     * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
     * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
     * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
     *
     * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
     * zu 'running'.
     */
    //	'CLOSED' => true,

    /**
     * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
     * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
     * Anzeigetext benutzt
     */
    "TITLE" => "MRMCD 2024",

    /**
     * Veranstalter
     * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    "AUTHOR" => "MRMCD e.V.",

    /**
     * Beschreibungstext
     * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    "DESCRIPTION" =>
        "Die MRMCDs haben seit 20 Jahren ihr Seepferdchen und dieses Jahr hissen wir die Flagge mit dem Motto „Land in Sicht?“.",

    /**
     * Schlüsselwortliste, Kommasepariert
     * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
     * <meta>-Tag generiert.
     */
    "KEYWORDS" =>
        "MRMCD, CCC, Chaos, Computer, Club, Konferenz, Land in Sicht?, 20 Jahre MRMCD, MRMCD Jubiläum, MRMCD 2024",

    /**
     * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
     * Sollte üblicherweise nur Inline-Elemente enthalten
     * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
     */
    "FOOTER_HTML" => '
		by <a href="https://mrmcd.net/">MRMCD</a> &amp;
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
    //	'BANNER_HTML' => '<img src="../configs/conferences/jh-hh-2019/Banner_JH-Hamburg-2019.svg" class="jhhh">',
    "BANNER_HTML" => '
            <div class="banner container">
                <div class="banner-content">
                    <span class="banner-content-name">MRMCD 2024</span>
                    <h1>
                        Land in Sicht?
                    </h1>
                    <span class="banner-content-date">3. bis 6.10.2024 TU Darmstadt</span>
                </div>
            </div>
        ',

    /**
     * Link zu den Recordings
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
    "RELEASES" => "https://media.ccc.de/c/mrmcd24",

    /**
     * Link zu einer (externen) ReLive-Übersichts-Seite
     * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
     */
    //	'RELIVE' => 'http://vod.c3voc.de/',

    /**
     * Alternativ kann ein ReLive-Json konfiguriert werden, um die interne
     * ReLive-Ansicht zu aktivieren.
     *
     * Wird beides aktiviert, hat der externe Link Vorrang!
     * Wird beides auskommentiert, wird der Link nicht angezeigt
     */
    //	'RELIVE_JSON' => 'configs/conferences/jh-hh-2019/vod.json',

    /**
     * APCU-Cache-Zeit in Sekunden
     * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
     * das Relive-Json bei jedem Request von der Quelle geladen und geparst
     */
    //	'RELIVE_JSON_CACHE' => 30*60,
];

/**
 * Konfiguration der Stream-Übersicht auf der Startseite
 */
$CONFIG["OVERVIEW"] = [
    /**
     * Abschnitte aud der Startseite und darunter aufgeführte Räume
     * Es können beliebig neue Gruppen und Räume hinzugefügt werden
     *
     * Die Räume müssen in $CONFIG['ROOMS'] konfiguriert werden,
     * sonst werden sie nicht angezeigt.
     */
    "GROUPS" => [
        "Lecture Rooms" => ["oceanstarr", "rainbowwarrior", "trockendock"],
    ],
];

/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG["ROOMS"] = [
    "oceanstarr" => [
        "DISPLAY" => "C205 - Ocean Starr",
        // TODO: VOC
        "STREAM" => "s3",
        "PREVIEW" => true,
        "TRANSLATION" => false,
        "SD_VIDEO" => true,
        "HD_VIDEO" => true,
        "DASH" => true,
        "H264_ONLY" => true,
        "HLS" => true,
        "SLIDES" => false,
        "AUDIO" => false,
        "MUSIC" => false,
        "SCHEDULE" => true,
        "SCHEDULE_NAME" => "C205 - Ocean Starr",
        "FEEDBACK" => false,
        "SUBTITLES" => false,
        "EMBED" => true,
        "IRC" => false,
        "TWITTER" => false,
    ],
    "rainbowwarrior" => [
        "DISPLAY" => "C120 - Rainbow Warrior",
        // TODO: VOC
        "STREAM" => "s4",
        "PREVIEW" => true,
        "TRANSLATION" => false,
        "SD_VIDEO" => true,
        "HD_VIDEO" => true,
        "DASH" => true,
        "H264_ONLY" => true,
        "HLS" => true,
        "SLIDES" => false,
        "AUDIO" => false,
        "MUSIC" => false,
        "SCHEDULE" => true,
        "SCHEDULE_NAME" => "C120 - Rainbow Warrior",
        "FEEDBACK" => false,
        "SUBTITLES" => false,
        "EMBED" => true,
        "IRC" => false,
        "TWITTER" => false,
    ],
    "trockendock" => [
        "DISPLAY" => "B002 - Trockendock",
        // TODO: VOC
        "STREAM" => "s5",
        "PREVIEW" => true,
        "TRANSLATION" => false,
        "SD_VIDEO" => true,
        "HD_VIDEO" => true,
        "DASH" => true,
        "H264_ONLY" => true,
        "HLS" => true,
        "SLIDES" => false,
        "AUDIO" => false,
        "MUSIC" => false,
        "SCHEDULE" => true,
        "SCHEDULE_NAME" => "B002 - Trockendock",
        "FEEDBACK" => false,
        "SUBTITLES" => false,
        "EMBED" => true,
        "IRC" => false,
        "TWITTER" => false,
    ],
];

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG["EMBED"] = true;

/**
 * Konfigurationen zum Konferenz-Fahrplan
 * Wird dieser Block auskommentiert, werden alle Fahrplan-Bezogenen Features deaktiviert
 */
$CONFIG["SCHEDULE"] = [
    /**
     * URL zum Fahrplan-XML
     *
     * Diese URL muss immer verfügbar sein, sonst können kann die Programm-Ansicht
     * aufhören zu funktionieren. Wenn die Quelle unverlässlich ist ;) sollte ein
     * externer HTTP-Cache vorgeschaltet werden.
     */
    "URL" => "https://talks.mrmcd.net/2024/schedule/export/schedule.xml",

    /**
     * Nur die angegebenen Räume aus dem Fahrplan beachten
     *
     * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
     */
    "ROOMFILTER" => ["C205 - Ocean Starr", "C120 - Rainbow Warrior", "B002 - Trockendock"],

    /**
     * Skalierung der Programm-Vorschau in Sekunden pro Pixel
     */
    "SCALE" => 7,

    /**
     * Simuliere das Verhalten als wäre die Konferenz bereits heute
     *
     * Diese folgende Beispiel-Zeile Simuliert, dass das
     * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
     */
    //'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2019-05-21') - strtotime(/* Today */ '2019-05-19'),
    "SIMULATE_OFFSET" => 0,
];

return $CONFIG;
