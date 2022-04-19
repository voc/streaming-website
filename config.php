<?php

date_default_timezone_set('Europe/Berlin');
$GLOBALS['CONFIG'] = [];

/**
 * Wenn die Webseite über diese Domain aufgerufen wird,
 * werden alle OPEN/CLOSED Informationen der einzelnen Konferenzen
 * ignoriert und immer alle Konferenzen in der Übersicht angezeigt.
 *
 * Dies eignet sich gut zum testen der Streaming-Seite, während
 * die eigenliche Produktivseite noch nicht sichtbar ist.
 *
 * Für die Lokale entwicklung kann es hilfreich sein, diese auf
 * 'localhost' zu setzen und so ebenfalls unabhängig von den OPEN/CLOSED
 * Informationen der einzelnen Konferenzen testen zu können.
 */
$GLOBALS['CONFIG']['PREVIEW_DOMAIN'] = 'xlocalhost';

/**
 * Während der Entwicklung wird die BASEURL automatisch erraten
 * In Produktionssituationen sollte manuell eine konfiguriert werden um Überraschungen zu vermeiden
 *
 * Protokollfreie URLs (welche, die mit // beginnen), werden automatisch mit dem korrekten Protokoll ergänzt.
 * In diesem Fall wird auch ein SSL-Umschalt-Button im Header angezeigt
 */
if(@$_SERVER['SERVER_NAME'] == 'localhost')
{
	// keine Konfiguration -> BASEURL wird automatisch erraten
}
else if(@$_SERVER['SERVER_NAME'] == 'streaming.test.c3voc.de')
{
	$GLOBALS['CONFIG']['BASEURL'] = '//streaming.test.c3voc.de/';
}
else
{
	// Set a safe Default
	$GLOBALS['CONFIG']['BASEURL'] = '//streaming.media.ccc.de/';
}


/**
 * Konfiguration für den Datei-Download Cronjob
 */
$GLOBALS['CONFIG']['DOWNLOAD'] = [
	/**
	 * Verweigeren Download, wenn der PHP-Prozess unter einem anderen Benutzer als diesem läuft
	 * Auskommentieren um alle Benutzer zu erlauben
	 */
	//'REQUIRE_USER' => 'www-data',

	/**
	 * Wartende HTTP-Downloads nach dieser Anzahl von Sekunden abbrechen
	 */
	'HTTP_TIMEOUT' => 5 /* Sekunden */,

	/**
	 * Nur Dateien von Konferenzen herunterladen, die weniger als
	 * diese Anzahl von Tagen alt sind (gemessen am END_DATE)
	 *
	 * Auskommentieren, um alle Konferenzen zu beachten
	 */
	'MAX_CONFERENCE_AGE' => 365 /* Tage */,
];

$GLOBALS['CONFIG']['CDN'] = "cdn.c3voc.de";
/**
 * Konfiguration der Room-Defaults
 *
 * Falls in der Raum-Konfiguration innerhalb der Konferenz für diese Keys nichts definiert ist, 
 * fällt das System auf diese Werte zurück.
 */

$GLOBALS['CONFIG']['ROOM_DEFAULTS'] = array(
	'WIDE' => true,

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
	/*
	'TRANSLATION' => [
		['endpoint' => 'translated',   'label' => 'Translated1'],
		['endpoint' => 'translated-2', 'label' => 'Translated2']
	],
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
	'H264_ONLY' => true,

	/**
	 * Slide-Only-Stream (1024×576) verfügbar
	 *
	 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist ẃird kein Slide-Only-
	 * Stream angeboten. Für diesen Raum wird dann keim Slides-Tab angeboten.
	 *
	 * In diesem Fall wird, sofern jeweils aktiviert, Audio und zuletzt Musik als
	 * Default-Stream angenommen.
	 */
	'SLIDES' => false,

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
	 * des $CONFIG['SCHEDULE']-Blocks in der Konferenz Config deaktiviert werden
	 */
	'SCHEDULE' => true,

	/**
	 * Feedback anzeigen (boolean)
	 *
	 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
	 * taucht der Raum auch im globalen Feedback-Formular nicht auf.
	 *
	 * Ebenso können alle Feedback-Funktionialitäten durch auskommentieren
	 * des $CONFIG['FEEDBACK']-Blocks deaktiviert werden
	 */
	'FEEDBACK' => true,

	/**
	 * Subtitles-Player aktivieren (boolean)
	 *
	 * Wenn diese Zeile auskommentiert oder auf false gesetzt ist,
	 * wird der Subtitles-Button und die damit verbundenen Funktionen deaktiviert.
	 *
	 * Ebenso können alle Subtitles-Funktionialitäten durch auskommentieren
	 * des $CONFIG['SUBTITLES']-Blocks deaktiviert werden
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
	 * des $CONFIG['EMBED']-Blocks in der Konferenz Config deaktiviert werden
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
	 * des $CONFIG['IRC']-Blocks in der Konferenz Config deaktiviert werden
	 */
	'IRC' => true,

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
	 * des $CONFIG['TWITTER']-Blocks deaktiviert werden
	 **/
	'TWITTER' => true,
);