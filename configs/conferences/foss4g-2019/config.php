<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2019-08-28 07:00"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt. 
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2019-08-30 19:00"),

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
	'TITLE' => 'FOSS4G 2019 Bucharest',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'AUTHOR' => 'OSGeo',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'DESCRIPTION' => 'FOSS4G is the annual global event of the Open Source Geospatial Foundation (OSGeo). Although widely recognized as the largest technical geospatial Open Source conference we call FOSS4G an "event" because it is far more than "just" a conference. A typical FOSS4G will include regular presentations and talks, but also code sprints, birds of a feather sessions, workshops, topic talks and of course social events spanning all nine days.',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'FOSS4G, Open Source, Geospatial Foundation, OSGeo, 2016, WCCB, Bonn, Video, Streaming, Live, Livestream',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		by <a href="http://www.osgeo.org">OSGeo</a> &amp;
		<a href="https://c3voc.de">C3VOC</a> &amp;
        <a href="https://2019.foss4g.org/">FOSS4G2019</a> &amp;
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
	//'BANNER_HTML' => '31C3 – a new dawn',

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'https://media.ccc.de/c/foss4g2019/',

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
	'RELIVE_JSON' => 'http://live.ber.c3voc.de/relive/foss4g2019/index.json',

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
            'NationalTheater',
			'Ronda',
			'Rapsodia',
			'FortunaW',
            'FortunaE',
            'Opera',
            'Menuet',
            'Coralle',
            'Opereta',
            'Simfonia',
            'Hora',
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
	'Ronda' => array(
		/**
		 * Angezeige-Name
		 */
		'DISPLAY' => 'Ronda Ballroom',

		/**
		 * ID des Video/Audio-Streams. Die Stream-ID ist davon abhängig, welches
		 * Event-Case in welchem Raum aufgebaut wird und wird üblicherweise von
		 * s1 bis s5 durchnummeriert.
		 */
		'STREAM' => 's1',

		/**
		 * Stream-Vorschaubildchen auf der Übersichtsseite anzeigen
		 * Damit das funktioniert muss der entsprechende runit-Task auf dem
		 * CDN-Quell-Host (live.ber) laufen.
		 */
        'PREVIEW' => true,

        'STEREO' => false,

		/**
		 * Übersetzungstonspur aktivieren
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist werden nur
		 * die native-Streams verwendet, andernfalls wird native und translated
		 * angeboten und auch für beide Tonspuren eine Player-Seite angezeigt.
		 */
		'TRANSLATION' => false,

		/**
		 * stereo-Tonspur statt native-Tonspur benutzen
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist werden
		 * die "native"-Mono-Streams verwendet, andernfalls wird statt "native"
		 * der Streamname "stereo" eingesetzt. Im normalen Konferenz-Setup
		 * müssen dann beide Kanäle der Kamera mit einem Signal bespielt werden.
		 */
		'STEREO' => false,

		/**
		 * SD-Video-Stream (1024×576) verfügbar
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist ẃird kein SD-Video
		 * angeboten. Wird auch HD_VIDEO auf false gesetzt oder auskommentiert ist, wird
		 * für diesen Raum überhaupt kein Video angeboten.
		 *
		 * In diesem Fall wird, sofern jeweils aktiviert, Slides, Audio und zuletzt Musik
		 * als Default-Stream angenommen.
		 */
		'SD_VIDEO' => true,

		/**
		 * HD-Video-Stream (1920×1080) verfügbar
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist ẃird kein HD-Video
		 * angeboten. Wird auch SD_VIDEO auf false gesetzt oder auskommentiert ist, wird
		 * für diesen Raum überhaupt kein Video angeboten.
		 *
		 * In diesem Fall wird, sofern jeweils aktiviert, Slides, Audio und zuletzt Musik
		 * als Default-Stream angenommen.
		 */
        'HD_VIDEO' => true,

        'DASH' => true,

		/**
		 * Slide-Only-Stream (1024×576) verfügbar
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist ẃird kein Slide-Only-
		 * Stream angeboten. Für diesen Raum wird dann keim Slides-Tab angeboten.
		 *
		 * In diesem Fall wird, sofern jeweils aktiviert, Audio und zuletzt Musik als
		 * Default-Stream angenommen.
		 */
		'SLIDES' => true,

		/**
		 * Audio-Only-Stream verfügbar
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist ẃird kein Audio-Only-
		 * Stream angeboten. Für diesen Raum wird dann keim Audio-Tab angeboten.
		 *
		 * In diesem Fall wird, sofern aktiviert, Musik als Default-Stream angenommen.
		 */
		'AUDIO' => true,

		/**
		 * Musik-Stream verfügbar
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist ẃird kein Musik-Stream
		 * angeboten. Für diesen Raum wird dann keim Musik-Tab angeboten.
		 *
		 * Ist kein einziger Stream angebote, wird statt der Stream-Seite ein 404-Fehler
		 * angezeigt.
		 */
		'MUSIC' => false,

		/**
		 * Fahrplan-Ansicht auf der Raum-Seite aktivieren (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird der Raum nicht im Fahrplan gesucht und auch auf der Startseite
		 * findet keine Darstellung statt.
		 *
		 * Ebenso können alle Fahrplan-Funktionialitäten durch auskommentieren
		 * des globalen $CONFIG['SCHEDULE']-Blocks deaktiviert werden
		 */
		'SCHEDULE' => true,

		/**
		 * Name des Raums im Fahrplan
		 * Wenn diese Zeile auskommentiert ist wird der Raum-Slug verwendet
		 */
		'SCHEDULE_NAME' => 'Ronda Ballroom',

		/**
		 * Feedback anzeigen (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * taucht der Raum auch im globalen Feedback-Formular nicht auf.
		 *
		 * Ebenso können alle Feedback-Funktionialitäten durch auskommentieren
		 * des globalen $CONFIG['FEEDBACK']-Blocks deaktiviert werden
		 */
		'FEEDBACK' => false,

		/**
		 * Subtitles-Player aktivieren (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird der Subtitles-Button und die damit verbundenen Funktionen deaktiviert.
		 *
		 * Ebenso können alle Subtitles-Funktionialitäten durch auskommentieren
		 * des globalen $CONFIG['SUBTITLES']-Blocks deaktiviert werden
		 */
		'SUBTITLES' => false,

		/**
		 * Embed-Form aktivieren (boolean)
		 *
		 * Ist dieses Feld auf true gesetzt, wird ein Embed-Tab unter dem Video
		 * angezeigt. Darüber kann der Player als iframe eingebunden werden.
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird kein Embed-Tab angeboten und die URL zum Einbetten existiert nicht.
		 *
		 * Ebenso können alle Embedding-Funktionialitäten durch auskommentieren
		 * des globalen $CONFIG['EMBED']-Blocks deaktiviert werden
		 */
		'EMBED' => true,

		/**
		 * IRC-Link aktivieren (boolean)
		 *
		 * Solange Twitter oder IRC aktiviert ist, wird ein "Chat"-Tab mit den
		 * jeweiligen Links angezeigt.
		 *
		 * Ist dieses Feld auf true gesetzt, wird ein irc://-Link angezeigt.
		 * WebIrc wird nach dem Congress nicht mehr unterstützt ;)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird kein IRC-Link angezeigt
		 *
		 * Ebenso können alle IRC-Links durch auskommentieren
		 * des globalen $CONFIG['IRC']-Blocks deaktiviert werden
		 */
		'IRC' => false,

		/**
		* Mit dem Angaben in diesem Block können die Vorgaben aus dem
		* globalen $CONFIG['IRC'] Block überschrieben werden.
		*
		* Der globale $CONFIG['IRC']-Block muss trotzdem existieren,
		* da sonst überhaupt kein IRC-Link erzeugt wird. (ggf. einfach `= true` setzen)
		*/
		'IRC_CONFIG' => true,

		/**
		 * Twitter-Link aktiviernn (boolean)
		 *
		 * Ist dieses Feld auf true gesetzt, wird ein Link zu Twitter angezeigt.
		 *
		 * Solange Twitter oder IRC aktiviert ist, wird ein "Chat"-Tab mit den
		 * jeweiligen Links angezeigt.
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird kein Twitter-Link angezeigt
		 *
		 * Ebenso können alle Twitter-Links durch auskommentieren
		 * des globalen $CONFIG['TWITTER']-Blocks deaktiviert werden
		 **/
		'TWITTER' => true,

		/**
		* Mit dem Angaben in diesem Block können die Vorgaben aus dem
		* globalen $CONFIG['TWITTER'] Block überschrieben werden.
		*
		* Der globale $CONFIG['TWITTER']-Block muss trotzdem existieren,
		* da sonst überhaupt kein IRC-Link erzeugt wird. (ggf. einfach `= true` setzen)
		*/
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#ronda @ fediverse/twitter',
			'TEXT'    => '#ronda #foss4g2019',
		),
	),

	'Rapsodia' => array(
		'DISPLAY' => 'Rapsodia Ballroom',
		'STREAM' => 's2',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Rapsodia Ballroom',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#rapsodia @ fediverse/twitter',
             'TEXT'    => '#rapsodia #foss4g2019',
         ),
	),

	'FortunaW' => array(
		'DISPLAY' => 'Fortuna West',
		'STREAM' => 's3',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Fortuna West',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#fortunawest @ fediverse/twitter',
             'TEXT'    => '#fortunawest #foss4g2019',
         ),
	),

	'FortunaE' => array(
		'DISPLAY' => 'Fortuna East',
		'STREAM' => 's4',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Fortuna East',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#fortunaeast @ fediverse/twitter',
             'TEXT'    => '#fortunaeast #foss4g2019',
         ),
	),

	'Opera' => array(
		'DISPLAY' => 'Opera',
		'STREAM' => 's5',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Opera Room',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#opera @ fediverse/twitter',
             'TEXT'    => '#opera #foss4g2019',
         ),
	),

	'Menuet' => array(
		'DISPLAY' => 'Menuet',
		'STREAM' => 's6',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Menuet',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#menuet @ fediverse/twitter',
             'TEXT'    => '#menuet #foss4g2019',
         ),
	),

	'Coralle' => array(
		'DISPLAY' => 'Coralle',
		'STREAM' => 's7',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Coralle Room',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#coralle @ fediverse/twitter',
             'TEXT'    => '#coralle #foss4g2019',
         ),
	),

	'Opereta' => array(
		'DISPLAY' => 'Opereta',
		'STREAM' => 's8',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Opereta Room',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#opereta @ fediverse/twitter',
             'TEXT'    => '#opereta #foss4g2019',
         ),
	),

	'Simfonia' => array(
		'DISPLAY' => 'Simfonia',
		'STREAM' => 's9',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Simfonia',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#simfonia @ fediverse/twitter',
             'TEXT'    => '#simfonia #foss4g2019',
         ),
	),

	'Hora' => array(
		'DISPLAY' => 'Hora',
		'STREAM' => 's10',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Hora Room',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#hora @ fediverse/twitter',
             'TEXT'    => '#hora #foss4g2019',
         ),
	),

	'NationalTheater' => array(
		'DISPLAY' => 'National Theater Plenary Hall',
		'STREAM' => 's11',
        'PREVIEW' => true,
        'STEREO' => false,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
        'HD_VIDEO' => true,
        'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
        'SCHEDULE_NAME' => 'Plenary (National Theatre)',

		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
        'TWITTER' => true,
        'IRC_CONFIG' => true,
        'TWITTER_CONFIG' => array(
             'DISPLAY' => '#plenary @ fediverse/twitter',
             'TEXT'    => '#plenary #foss4g2019',
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
	 * Diese URL muss immer verfügbar sein, sonst können kann die Programm-Ansicht
	 * aufhören zu funktionieren. Wenn die Quelle unverlässlich ist ;) sollte ein
	 * externer HTTP-Cache vorgeschaltet werden.
	 */
	'URL' => 'https://talks.2019.foss4g.org/bucharest/schedule/export/schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
	'ROOMFILTER' => array(  'Plenary (National Theatre)',
                            'Ronda Ballroom',
                            'Fortuna West',
                            'Fortuna East',
                            'Rapsodia Ballroom',
                            'Opera Room',
                            'Opereta Room',
                            'Simfonia',
                            'Menuet',
                            'Hora Room',
                            'Coral Room',
                            ),

	/**
	 * APCU-Cache-Zeit in Sekunden
	 * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
	 * der Fahrplan bei jedem Request von der Quelle geladen und geparst
	 */
	//'CACHE' => 30*60,

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 3,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
	 */
	'SIMULATE_OFFSET' => 0,
);



/**
 * Konfiguration des Feedback-Formulars
 *
 * Wird dieser Block auskommentiert, wird das gesamte Feedback-System deaktiviert
 */
$CONFIG['FEEDBACK'] = array(
	/**
	 * DSN zum abspeichern der eingegebenen Daten
	 * die Datenbank muss eine Tabelle enthaltem, die dem in `lib/schema.sql` angegebenen
	 * Schema entspricht.
	 *
	 * Achtung vor Dateirechten: Bei SQLite reicht es nicht, wenn wer Webseiten-Benutzer
	 * die .sqlite3-Datei schreiben darf, er muss auch im übergeordneten Order neue
	 * (Lock-)Dateien anlegen dürfen
	 */
	'DSN' => 'sqlite:/opt/streaming-feedback/feedback.sqlite3',

	/**
	 * Login-Daten für die /feedback/read/-Seite, auf der eingegangenes
	 * Feedback gelesen werden kann.
	 *
	 * Durch auskommentieren der beiden Optionen wird diese Seite komplett deaktiviert,
	 * es kann dann nur noch durch manuelle Inspektion der .sqlite3-Datei auf das Feedback
	 * zugegriffen werden.
     */
	'USERNAME' => 'katze',
	'PASSWORD' => trim(@file_get_contents('/opt/streaming-feedback/feedback-password')),
);

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;

/**
 * Globale Konfiguration der IRC-Links.
 *
 * Wird dieser Block auskommentiert, werden keine IRC-Links mehr erzeugt. Sollen die
 * IRC-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 */

$CONFIG['IRC'] = true;
/**
$CONFIG['IRC'] = array(
	/**
	 * Anzeigetext für die IRC-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
	 * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
	 
	'DISPLAY' => '#camp @ hackint',

	/**
	 * URL für die IRC-Links.
	 * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
	 * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#31C3-%s'
	 * verwendet werden.
	 *
	 * %s wird durch den urlencodeten Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 
	'URL' => 'https://webirc.hackint.org/#irc://irc.hackint.org/#camp',
);
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

$CONFIG['TWITTER'] = array(
	/**
	 * Anzeigetext für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Ist eine weitere Anpassung erfoderlich, kann ein TWITTER_CONFIG-Block in der
	 * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
     */
	'DISPLAY' => '#foss4g2019 @ fediverse/twitter',

	/**
	 * Vorgabe-Tweet-Text für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'TEXT' => '#foss4g2019',
);


return $CONFIG;
