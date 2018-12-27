<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2018-12-27 06:00"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2018-12-30 20:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	 // 'CLOSED' => false,

	/**
	 * Mit diesem Schalter kann die Veranstaltung von der Startseite und der API
	 * versteckt werden, ist aber dennoch über ihre URL verfügbar.
	 *
	 * Dies ist z.B. nützlich um eine kleinere Streamingseite für Übersetzer
	 * bereit zu stellen. Werte: true|false Default: false
	 */
	 'UNLISTED' => false,

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => '35C3',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'AUTHOR' => 'CCC',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'DESCRIPTION' => 'Live streaming from the 35th Chaos Communication Congress',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => '35C3, Hacking, Chaos Computer Club, Video, Music, Podcast, Media, Streaming, Hacker, Leipzig, Refreshing Memories',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		by <a href="https://ccc.de">Chaos Computer Club e.V</a>,
		<a href="https://www.isystems.at/">iSystems</a>,
		<a href="https://fem.tu-ilmenau.de/">FeM</a>,
		<a href="https://www.ags.tu-bs.de/">ags</a> &
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
	'BANNER_HTML' => '
		<h1>35C3 REFRESHING MEMORIES</h1>
		<img class="block" src="configs/conferences/35c3/assets/min/35C3_Logo-mit-Verlauf.svg" alt="35C3 refreshing memories logo block"/>
		<img class="inline" src="configs/conferences/35c3/assets/logo-inline.svg" alt="35C3 refreshing memories logo inline"/>
	',

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'https://media.ccc.de/c/35c3',

	/**
	 * Um die interne ReLive-Ansicht zu aktivieren, kann hier ein ReLive-JSON
	 * konfiguriert werden. Üblicherweise wird diese Datei über das Script
	 * configs/download.sh heruntergeladen, welches von einem Cronjob
	 * regelmäßig getriggert wird.
	 *
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELIVE_JSON' => 'https://live.dus.c3voc.de/relive/35c3/index.json', # TODO setup, configure correct value
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
			'halla',
			'hallb',
			'hallc',
			'halld',
			'halle',
		),
		'Assemblies Live' => array(
			'chaoswest',
			'wikipakawg',
			'oio'
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
	 *
	 * Der Raum-Slug darf ausschliesslich aus "unkritischen" Zeichen
	 * ([a-zA-Z0-9_\-]) bestehen und insbesondere keine Leerzeichen
	 * enthalten.
	 */
	'halla' => array(
		/**
		 * Angezeige-Name
		 */
		'DISPLAY' => 'Adams',

		'WIDE' => true,

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

		/**
		 * Übersetzungstonspur aktivieren
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist werden nur
		 * die native-Streams verwendet, andernfalls wird native und translated
		 * angeboten und auch für beide Tonspuren eine Player-Seite angezeigt.
		 *
		 * Betrifft video sd / hd, slides, audio
		 *
		 * Ein Label für die Übersetzung oder mehrere Übersetzungsspuren können
		 * wie folgt konfiguriert werden:
		 *
		 * 'TRANSLATION' => [
		 *    ['endpoint' => 'translated',   'label' => 'Translated1'],
		 *    ['endpoint' => 'translated-2', 'label' => 'Translated2']
		 * ],
		 *
		 * Ein einfaches true entspricht dabei folgendem:
		 *
		 * 'TRANSLATION' => [
		 *   ['endpoint' => 'translated', 'label' => 'Translated']
		 * ],
		 *
		 * Sollte die Sprache während der Veranstaltung Konstant sein, kann ein
		 * Label auch spezifisch konfiguriert werden z.B. 'label' => 'English'.
		 */
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],

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
		 * Wenn diese Zeile auskommentiert ist wird der Raum-Display-Name verwendet
		 */
		'SCHEDULE_NAME' => 'Adams',

		/**
		 * Feedback anzeigen (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * taucht der Raum auch im globalen Feedback-Formular nicht auf.
		 *
		 * Ebenso können alle Feedback-Funktionialitäten durch auskommentieren
		 * des globalen $CONFIG['FEEDBACK']-Blocks deaktiviert werden
		 */
		'FEEDBACK' => true,

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
		 * ID des Raumes im L2S2-System (int)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * für diesen Raum das Subtitles-System deaktiviert.
		 */
		'SUBTITLES_ROOM_ID' => 1,

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
		'IRC' => true,

		/**
		* Mit dem Angaben in diesem Block können die Vorgaben aus dem
		* globalen $CONFIG['IRC'] Block überschrieben werden.
		*
		* Der globale $CONFIG['IRC']-Block muss trotzdem existieren,
		* da sonst überhaupt kein IRC-Link erzeugt wird. (ggf. einfach `= true` setzen)
		*/
		'IRC_CONFIG' => array(
			'DISPLAY' => '#35C3-hall-a @ hackint', # TODO same value as last year, but maybe check with signal angel
			'URL'     => 'irc://irc.hackint.eu:6667/35C3-hall-a',
		),

		/**
		 * Twitter-Link aktivieren (boolean)
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
			'DISPLAY' => '#hallA @ twitter',
			'TEXT'    => '#35C3 #hallA',
		),
	),

	'hallb' => array(
		'DISPLAY' => 'Borg',
		'STREAM' => 's2',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Borg',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#35C3-hall-b @ hackint', # TODO check
			'URL'     => 'irc://irc.hackint.eu:6667/35C3-hall-b',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hallB @ twitter',
			'TEXT'    => '#35C3 #hallB',
		),
	),

	'hallc' => array(
		'DISPLAY' => 'Clarke',
		# Joan Clarke
		'STREAM' => 's3',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Clarke',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#35C3-hall-c @ hackint', # TODO check
			'URL'     => 'irc://irc.hackint.eu:6667/35C3-hall-c',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hallC @ twitter',
			'TEXT'    => '#35C3 #hallC',
		),
	),

	'halld' => array(
		'DISPLAY' => 'Dijkstra',
		'STREAM' => 's4',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Dijkstra',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#35C3-hall-d @ hackint', # TODO check
			'URL'     => 'irc://irc.hackint.eu:6667/35C3-hall-d',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hallD @ twitter',
			'TEXT'    => '#35C3 #hallD',
		),
	),

	'halle' => array(
		'DISPLAY' => 'Eliza',
#		'WIDE' => true,
		'STREAM' => 's5',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => true,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Eliza',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#35C3-hall-e @ hackint', # TODO check
			'URL'     => 'irc://irc.hackint.eu:6667/35C3-hall-e',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hallE @ twitter',
			'TEXT'    => '#35C3 #hallE',
		),
	),

	'chaoswest' => array(
		'DISPLAY' => 'Chaos West Bühne',
		'STREAM' => 's150',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Chaos West Bühne',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '@ChaosWildWest @ twitter',
			'TEXT'    => '@ChaosWildWest',
		),
	),

	'wikipakawg' => array(
		'DISPLAY' => 'WikiPakaWG Esszimmer',
		'STREAM' => 's151',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'WikiPakaWG Esszimmer',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#wikipakaWG @ twitter',
			'TEXT'    => '#wikipakaWG',
		),
	),

	'oio' => array(
		'DISPLAY' => 'Open Infrastructure Orbit Vortrags-Arena',
		'STREAM' => 'soio',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'OIO Vortrags-Arena',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => 'freifunk @ twitter',
			'TEXT'    => '@freifunk',
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
	#'URL' => 'https://fahrplan.events.ccc.de/congress/2018/Fahrplan/schedule.xml',
	#'URL' => 'https://events.ccc.de/congress/2018/Fahrplan/schedule.xml',
	'URL' => 'http://data.c3voc.de/35C3/everything.schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
	'ROOMFILTER' => array('Adams', 'Borg', 'Clarke', 'Dijkstra', 'Eliza',
		'WikiPakaWG Esszimmer', 'Chaos West Bühne', 'OIO Vortrags-Arena'),

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
 * Konfiguration des L2S2-Systems
 * https://github.com/c3subtitles/L2S2
 *
 * Wird dieser Block auskommentiert, wird das gesamte Subtitle-System deaktiviert
 */

// $CONFIG['SUBTITLES'] = array(
// 	/**
// 	 * URL des L2S2 Primus-Servers
// 	 */
// 	'PRIMUS_URL' => 'https://live.c3subtitles.de/',
//
// 	/**
// 	 * URL des L2S2 Frontend-Servers
// 	 */
// 	'FRONTEND_URL' => 'https://live.c3subtitles.de/',
// );

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
	/**
	 * Anzeigetext für die IRC-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
	 * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
	 */
	'DISPLAY' => '#35C3-%s @ hackint',

	/**
	 * URL für die IRC-Links.
	 * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
	 * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#33C3-%s'
	 * verwendet werden.
	 *
	 * %s wird durch den urlencodeten Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'URL' => 'irc://irc.hackint.eu:6667/35C3-%s',
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
	'DISPLAY' => '#%s @ twitter',

	/**
	 * Vorgabe-Tweet-Text für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'TEXT' => '#35C3 #%s',
);

/**
 * Liste zusätzlich herunterzuladender Dateien
 *
 * Dict mit dem Dateinamen im Key und einer URL im Value. Die Dateien werden
 * unter dem angegebenen Dateinamen in diesem Konfigurationsordner abgelegt.
 */
$CONFIG['EXTRA_FILES'] = array(
	'schedule.xml'  => 'https://fahrplan.events.ccc.de/congress/2018/Fahrplan/schedule.xml',
	'schedule.json' => 'https://fahrplan.events.ccc.de/congress/2018/Fahrplan/schedule.json',
	'schedule.ics'  => 'https://fahrplan.events.ccc.de/congress/2018/Fahrplan/schedule.ics',
	'schedule.xcal' => 'https://fahrplan.events.ccc.de/congress/2018/Fahrplan/schedule.xcal',

	'everything.schedule.xml' => 'http://data.c3voc.de/35C3/everything.schedule.xml',
	'everything.schedule.json' => 'http://data.c3voc.de/35C3/everything.schedule.json',

	'workshops.schedule.xml' => 'http://data.c3voc.de/35C3/workshops.schedule.xml',
	'workshops.schedule.json' => 'http://data.c3voc.de/35C3/workshops.schedule.json',
);

return $CONFIG;
