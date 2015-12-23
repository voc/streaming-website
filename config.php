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
$GLOBALS['CONFIG']['PREVIEW_DOMAIN'] = 'pre.stream.c3voc.de';

/**
 * Während der Entwicklung wird die BASEURL automatisch erraten
 * In Produktionssituationen sollte manuell eine konfiguriert werden um Überraschungen zu vermeiden
 *
 * Protokollfreie URLs (welche, die mit // beginnen), werden automatisch mit dem korrekten Protokoll ergänzt.
 * In diesem Fall wird auch ein SSL-Umschalt-Button im Header angezeigt
 */
if($_SERVER['SERVER_NAME'] == 'localhost')
{
	// keine Konfiguration -> BASEURL wird automatisch erraten
}
// if($_SERVER['SERVER_NAME'] == 'pre.stream.c3voc.de')
// {
// 	// Preview-Domain
// 	$GLOBALS['CONFIG']['BASEURL'] = '//pre.stream.c3voc.de/';
// }
else
{
	// Save Default
	$GLOBALS['CONFIG']['BASEURL'] = '//streaming.media.ccc.de/';
}
