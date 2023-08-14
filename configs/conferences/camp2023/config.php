<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2023-08-14 19:30"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2023-08-19 23:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	//'CLOSED' => 'running',

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'Chaos Communication Camp 2023',

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
	'DESCRIPTION' => 'Video Live-Streaming of the Chaos Communication Camp 2023',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'cccamp, CCC, Chaos Communication Camp, Camp, 2023, Hacking, Chaos Computer Club, Video, Media, Streaming, Hacker',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		by <a href="https://ccc.de">Chaos Computer Club e.V</a>,
		<a href="http://www.ags.tu-bs.de/">ags</a>,
		<a href="https://www.fem.tu-ilmenau.de">FeM</a> &amp;
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
	<div class="container">
		<div class="row group group-marktplatz">
			<div class="col-xs-12">
				<h2><span>Marktplatz</span></h2>
			</div>
		</div>

		<div class="row room-group room-group-n0 room-group-marktplatz">
			<div class="room room-marktplatz clearfix wide col-xs-12">
				<a href="https://broadcast.fem.tu-ilmenau.de/events/cccamp23/">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								<span class="roomtitle regular">Marktplatz</span>
								<span class="roomtitle short">Marktplatz</span>
							</div>
						</div>

						<div class="panel-body">
							<img class="preview" src="http://cdn.c3voc.de/thumbnail/s1/thumb.jpeg" alt="Marktplatz" width="213" height="120">
						</div>
					</div>
				</a>
			</div
		</div>
	</div>
	',

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'https://media.ccc.de/c/camp2023',

	/**
	 * Alternativ kann ein ReLive-Json konfiguriert werden, um die interne
	 * ReLive-Ansicht zu aktivieren.
	 *
	 * Wird beides aktiviert, hat der externe Link Vorrang!
	 * Wird beides auskommentiert, wird der Link nicht angezeigt
	 */
	'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/camp2023/index.json',

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
		'C3VOC.TV' => array(
			'c3voctv'
        ),
        'Content' => array(
			'bits',
			'digital',
			'milliways',
			'nortx',
			'jh'
        ),
    ),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	'c3voctv' => array(
		'DISPLAY' => 'C3VOC.TV',
		'STREAM' => 's6',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
    	'HLS' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'C3VOC.tv',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'TWITTER' => true,
	),
	'bits' => array(
		'DISPLAY' => 'Bits & Bäume',
		'STREAM' => 's2',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
    	'HLS' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bits & Bäume',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'TWITTER' => true,
	),
	'digital' => array(
		'DISPLAY' => 'Digitalcourage',
		'STREAM' => 's3',
		'PREVIEW' => true,
		'TRANSLATION' => true,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
    	'HLS' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Digitalcourage',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'TWITTER' => true,
	),
	'milliways' => array(
		'DISPLAY' => 'Milliways',
		'STREAM' => 's4',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
    	'HLS' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Milliways',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'TWITTER' => true,
	),
	'nortx' => array(
		'DISPLAY' => 'N:O:R:T:x',
		'STREAM' => 's5',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
    	'HLS' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'N:O:R:T:x',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'TWITTER' => true,
	),
	'jh' => array(
		'DISPLAY' => 'Jugend Village',
		'STREAM' => 's191',
		'PREVIEW' => true,
		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
    	'HLS' => true,
		'SLIDES' => false,
		'AUDIO' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Jugend Village',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
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
	'DISPLAY' => 'Matrix: #camp2023 @ events.ccc.de',

	/**
	 * URL für die IRC-Links.
	 * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
	 * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#31C3-%s'
	 * verwendet werden.
	 *
	 * %s wird durch den urlencodeten Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'URL' => 'https://matrix.to/#/#camp2023:events.ccc.de',
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
	'DISPLAY' => '#CCCamp23 @ fediverse/twitter',

	/**
	 * Vorgabe-Tweet-Text für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'TEXT' => '#CCCamp23',
);

$CONFIG['SCHEDULE'] = array(
	/**
	 * URL zum Fahrplan-XML
	 *
	 * Diese URL muss immer verfügbar sein, sonst können kann die Programm-Ansicht
	 * aufhören zu funktionieren. Wenn die Quelle unverlässlich ist ;) sollte ein
	 * externer HTTP-Cache vorgeschaltet werden.
	 */
	'URL' => 'http://data.c3voc.de/camp2023/channels.schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
  'ROOMFILTER' => array('Marktplatz', 'Bits & Bäume', 'Digitalcourage', 'Milliways', 'N:O:R:T:x', 'Jugend Village', 'C3VOC.tv'),

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 7,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
	 */
	//'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2017-05-21') - strtotime(/* Today */ '2017-05-19'),
	'SIMULATE_OFFSET' => 0,
);

return $CONFIG;
