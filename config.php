<?php
date_default_timezone_set('Europe/Berlin');

/**
 * Während der Entwicklung wird die BASEURL automatisch erraten
 * In Produktionssituationen sollte manuell eine konfiguriert werden um Überraschungen zu vermeiden
 */
if($_SERVER['HTTP_HOST'] != 'localhost')
	$GLOBALS['CONFIG']['BASEURL'] = 'http://streaming.media.ccc.de/';


$GLOBALS['CONFIG']['CONFERENCE'] = array(
	'TITLE' => '31C3',
	'AUTHOR' => 'CCC',
	'DESCRIPTION' => 'Video Live-Streaming vom 31C3',
	'KEYWORDS' => '31C3, Hacking, Chaos Computer Club, Video, Media, Streaming, Hacker',

	'FOOTER_HTML' => '
		by <a href="https://ccc.de">Chaos Computer Club e.V</a>,
		<a href="http://fem.tu-ilmenau.de/">FeM</a>,
		<a href="http://www.ags.tu-bs.de/">ags</a> &amp;
		<a href="https://c3voc.de">c3voc</a>
	',
);

/**
 * Konfiguration der Stream-Übersicht auf der Startseite
 */
$GLOBALS['CONFIG']['OVERVIEW'] = array(
	/**
	 * Abschnitte aud der Startseite und darunter aufgeführte Räume
	 * Es können beliebig neue Gruppen und Räume hinzugefügt werden
	 *
	 * Die Räume müssen in $GLOBALS['CONFIG']['ROOMS'] konfiguriert werden,
	 * sonst werden sie nicht angezeigt.
	 */
	'GROUPS' => array(
		'Lecture Rooms' => array(
			'saal1',
			'saal2',
			'saalg',
			'saal6',
		),

		'Live DJ Sets'  => array(
			'lounge',
			'ambient',
		),
		'Live Podcasts' => array(
			'sendezentrum',
		),
	),

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'http://media.ccc.de/browse/congress/2014/index.html',

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
	'RELIVE_JSON' => 'http://localhost/streaming-website/test-vod.json',
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$GLOBALS['CONFIG']['ROOMS'] = array(
	/**
	 * Array-Key ist der Raum-Slug, der z.B. auch zum erstellen der URLs,
	 * in $GLOBALS['CONFIG']['OVERVIEW'] oder im Feedback verwendet wird.
	 */
	'saal1' => array(
		/**
		 * Angezeige-Name
		 */
		'DISPLAY' => 'Saal 1',

		/**
		 * Vefügbare Streaming-Formate
		 * Die Formate müssen in $GLOBALS['CONFIG']['FORMATS'] benannt sein, es
		 * können jedoch über die Config keine neuen erfunden werden; dazu sind
		 * Änderungen am Code erforderlich.
		 */
		'FORMATS' => array(
			'rtmp-sd', 'rtmp-hd',
			'hls-sd', 'hls-hd',
			'webm-sd', 'webm-hd',
			'audio-mp3', 'audio-opus',
			'slides',
		),

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
		 * Der Spezialwert 'stereo' (oder ein beliebiger anderer String) kann
		 * verwendet werden, um statt s1_native_sd Streamnamen in der Art von
		 * s1_<string>_sd, also z.B. s1_stereo_sd zu benutzen. Abgesehen von den
		 * anderen Streamnamen verhält sich die Seite, als wäre false gesetzt.
		 */
		'TRANSLATION' => true,

		/**
		 * Fahrplan-Ansicht auf der Raum-Seite aktivieren (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird der Raum nicht im Fahrplan gesucht und auch auf der Startseite
		 * findet keine Darstellung statt.
		 *
		 * Ebenso können alle Fahrplan-Funktionialitäten durch auskommentieren
		 * des globalen $GLOBALS['CONFIG']['SCHEDULE']-Blocks deaktiviert werden
		 */
		'SCHEDULE' => true,

		/**
		 * Name des Raums im Fahrplan
		 * Wenn diese Zeile auskommentiert ist wird der Raum-Slug verwendet
		 */
		'SCHEDULE_NAME' => 'Saal 1',

		/**
		 * Feedback anzeigen (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * taucht der Raum auch im globalen Feedback-Formular nicht auf.
		 *
		 * Ebenso können alle Feedback-Funktionialitäten durch auskommentieren
		 * des globalen $GLOBALS['CONFIG']['FEEDBACK']-Blocks deaktiviert werden
		 */
		'FEEDBACK' => true,

		/**
		 * Subtitles-Player aktivieren (boolean)
		 *
		 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
		 * wird der Subtitles-Button und die damit verbundenen Funktionen deaktiviert.
		 *
		 * Ebenso können alle Subtitles-Funktionialitäten durch auskommentieren
		 * des globalen $GLOBALS['CONFIG']['SUBTITLES']-Blocks deaktiviert werden
		 */
		'SUBTITLES' => true,

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
		 * des globalen $GLOBALS['CONFIG']['IRC']-Blocks deaktiviert werden
		 */
		'IRC' => true,

		/**
		* Mit dem Angaben in diesem Block können die Vorgaben aus dem
		* globalen $GLOBALS['CONFIG']['IRC'] Block überschrieben werden.
		*
		* Der globale $GLOBALS['CONFIG']['IRC']-Block muss trotzdem existieren,
		* da sonst überhaupt kein IRC-Link erzeugt wird. (ggf. einfach `= true` setzen)
		*/
		'IRC_CONFIG' => array(
			'DISPLAY' => '#31C3-hall-1 @ hackint',
			'URL'     => 'irc://irc.hackint.eu:6667/31C3-hall-1',
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
		 * des globalen $GLOBALS['CONFIG']['TWITTER']-Blocks deaktiviert werden
		 **/
		'TWITTER' => true,

		/**
		* Mit dem Angaben in diesem Block können die Vorgaben aus dem
		* globalen $GLOBALS['CONFIG']['TWITTER'] Block überschrieben werden.
		*
		* Der globale $GLOBALS['CONFIG']['TWITTER']-Block muss trotzdem existieren,
		* da sonst überhaupt kein IRC-Link erzeugt wird. (ggf. einfach `= true` setzen)
		*/
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hall1 @ twitter',
			'TEXT'    => '#31C3 #hall1',
		),
	),

	'saal2' => array(
		'DISPLAY' => 'Saal 2',
		'FORMATS' => array(
			'rtmp-sd', 'rtmp-hd',
			'hls-sd', 'hls-hd',
			'webm-sd', 'webm-hd',
			'audio-mp3', 'audio-opus',
			'slides',
		),
		'STREAM' => 's2',
		'PREVIEW' => true,
		'TRANSLATION' => true,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Saal 2',
		'FEEDBACK' => true,
		'SUBTITLES' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#31C3-hall-2 @ hackint',
			'URL'     => 'irc://irc.hackint.eu:6667/31C3-hall-2',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hall2 @ twitter',
			'TEXT'    => '#31C3 #hall2',
		),
	),

	'saalg' => array(
		'DISPLAY' => 'Saal G',
		'FORMATS' => array(
			'rtmp-sd', 'rtmp-hd',
			'hls-sd', 'hls-hd',
			'webm-sd',
			'audio-mp3', 'audio-opus',
			'slides',
		),
		'STREAM' => 's3',
		'PREVIEW' => true,
		'TRANSLATION' => true,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Saal G',
		'FEEDBACK' => true,
		'SUBTITLES' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#31C3-hall-g @ hackint',
			'URL'     => 'irc://irc.hackint.eu:6667/31C3-hall-g',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hallg @ twitter',
			'TEXT'    => '#31C3 #hallg',
		),
	),

	'saal6' => array(
		'DISPLAY' => 'Saal 6',
		'FORMATS' => array(
			'rtmp-sd', 'rtmp-hd',
			'hls-sd', 'hls-hd',
			'webm-sd', 'webm-hd',
			'audio-mp3', 'audio-opus',
			'slides',
		),
		'STREAM' => 's4',
		'PREVIEW' => true,
		'TRANSLATION' => true,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Saal 6',
		'FEEDBACK' => true,
		'SUBTITLES' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#31C3-hall-6 @ hackint',
			'URL'     => 'irc://irc.hackint.eu:6667/31C3-hall-6',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#hall6 @ twitter',
			'TEXT'    => '#31C3 #hall6',
		),
	),


	'lounge' => array(
		'DISPLAY' => 'Lounge',
		'FORMATS' => array(
			'music-mp3', 'music-opus',
		),
	),
	'ambient' => array(
		'DISPLAY' => 'Ambient',
		'FORMATS' => array(
			'music-mp3', 'music-opus',
		),
	),


	'sendezentrum' => array(
		'DISPLAY' => 'Sendezentrum',
		'FORMATS' => array(
			'rtmp-sd', 'rtmp-hd',
			'hls-sd', 'hls-hd',
			'webm-sd', 'webm-hd',
			'audio-mp3', 'audio-opus',
		),
		'STREAM' => 's5',
		'TRANSLATION' => false,
		'SCHEDULE' => true,
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'IRC' => false,
		'TWITTER' => false,
	),
);



/**
 * Konfigurationen zum Konferenz-Fahrplan
 * Wird dieser Block auskommentiert, werden alle Fahrplan-Bezogenen Features deaktiviert
 */
$GLOBALS['CONFIG']['SCHEDULE'] = array(
	/**
	 * URL zum Fahrplan-XML
	 *
	 * Diese URL muss immer verfügbar sein, sonst können kann die Programm-Ansicht
	 * aufhören zu funktionieren. Wenn die Quelle unverlässlich ist ;) sollte ein
	 * externer HTTP-Cache vorgeschaltet werden.
	 */
	'URL' => 'http://events.ccc.de/congress/2014/Fahrplan/schedule.xml',

	/**
	 * APCU-Cache-Zeit in Sekunden
	 * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
	 * der Fahrplan bei jedem Request von der Quelle geladen und geparst
	 */
	'CACHE' => 30*60,

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
	'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2014-12-28') - strtotime(/* Today */ '2015-03-01'),
	//'SIMULATE_OFFSET' => 0,
);



/**
 * Konfiguration des Feedback-Formulars
 *
 * Wird dieser Block auskommentiert, wird das gesamte Feedback-System deaktiviert
 */
$GLOBALS['CONFIG']['FEEDBACK'] = array(
	/**
	 * DSN zum abspeichern der eingegebenen Daten
	 * die Datenbank muss eine Tabelle enthaltem, die dem in `lib/schema.sql` angegebenen
	 * Schema entspricht.
	 *
	 * Achtung vor Dateirechten: Bei SQLite reicht es nicht, wenn wer Webseiten-Benutzer
	 * die .sqlite3-Datei schreiben darf, er muss auch im übergeordneten Order neue
	 * (Lock-)Dateien anlegen dürfen
	 */
	'DSN' => 'sqlite:/opt/31c3-streaming-feedback/feedback.sqlite3',

	/**
	 * Login-Daten für die /feedback/read/-Seite, auf der eingegangenes
	 * Feedback gelesen werden kann.
	 *
	 * Durch auskommentieren der beiden Optionen wird diese Seite komplett deaktiviert,
	 * es kann dann nur noch durch manuelle Inspektion der .sqlite3-Datei auf das Feedback
	 * zugegriffen werden.
	 */
	'USERNAME' => 'winke',
	'PASSWORD' => 'katze',
);

/**
 * Konfiguration des L2S2-Systems
 * https://github.com/c3subtitles/L2S2
 *
 * Wird dieser Block auskommentiert, wird das gesamte Subtitle-System deaktiviert
 */
$GLOBALS['CONFIG']['SUBTITLES'] = array(
	/**
	 * URL des L2S2-Servers
	 */
	'URL' => 'http://subtitles.c3voc.de/',
);

/**
 * Globale Konfiguration der IRC-Links.
 *
 * Wird dieser Block auskommentiert, werden keine IRC-Links mehr erzeugt. Sollen die
 * IRC-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $GLOBALS['CONFIG']['IRC'] = true
 */
$GLOBALS['CONFIG']['IRC'] = array(
	/**
	 * Anzeigetext für die IRC-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Ist eine weitere Anpassung erfoderlich, kann ein IRC_CONFIG-Block in der
	 * Raum-Konfiguration zum Überschreiben dieser Angaben verwendet werden.
	 */
	'DISPLAY' => '#31C3-%s @ hackint',

	/**
	 * URL für die IRC-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'URL' => 'irc://irc.hackint.eu:6667/31C3-%s',
);

/**
 * Globale Konfiguration der Twitter-Links.
 *
 * Wird dieser Block auskommentiert, werden keine Twitter-Links mehr erzeugt. Sollen die
 * Twitter-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $GLOBALS['CONFIG']['TWITTER'] = true
 */
$GLOBALS['CONFIG']['TWITTER'] = array(
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
	'TEXT' => '#31C3 #%s',
);




/**
 * Beschreibung der Streaming-Formate
 *
 * Achtung: Über diese Sektion können keine zusätzlichen Formate erstellt werden -- dazu
 * sind Code-Anpassungen erforderlich.
 *
 * In diesem Abschnitt können ausschließlich die Anzeigetexte für die verschiedenen
 * Streaming-Formate bearbeitet werden. Für jedes Streamingformat das in einem Raum
 * verwendet wird müssen hier Texte hinterlegt sein.
 */
$GLOBALS['CONFIG']['FORMAT'] = array(
	'rtmp-sd' => '1024x576, h264+AAC im FLV-Container via RTMP, 800 kBit/s',
	'rtmp-hd' => '1920x1080, h264+AAC im FLV-Container via RTMP, 3 MBit/s',

	'hls-sd' => '1024x576, h264+AAC im MPEG-TS-Container via HTTP, 800 kBit/s',
	'hls-hd' => '1920x1080, h264+AAC im MPEG-TS-Container via HTTP, 3 MBit/s',

	'webm-sd' => '1024x576, VP8+Vorbis in WebM, 800 kBit/s',
	'webm-hd' => '1920x1080, VP8+Vorbis in WebM, 3 MBit/s',

	'audio-mp3' => 'MP3-Audio, 96 kBit/s',
	'audio-opus' => 'Opus-Audio, 64 kBit/s',

	'music-mp3' => 'MP3-Audio, 320 kBit/s',
	'music-opus' => 'Opus-Audio, 128 kBit/s',

	'slides' => '1024x576, h264+AAC, <500 kBit/s',
);
