<?php

date_default_timezone_set('Europe/Berlin');

/**
 * Wenn die Webseite über diese Domain aufgerufen wird,
 * werden alle OPEN/CLOSED Informationen der einzelnen Konferenzen
 * ignoriert und immer alle Konferenzen in der Übersicht angezeigt.
 *
 * Dies eignet sich gut zum testen der Streaming-Seite, während
 * die eigenliche Produktivseite noch nicht sichtbar ist.
 */
$GLOBALS['CONFIG']['PREVIEW_DOMAIN'] = 'pre.stream.c3voc.de';

/**
 * Während der Entwicklung wird die BASEURL automatisch erraten
 * In Produktionssituationen sollte manuell eine konfiguriert werden um Überraschungen zu vermeiden
 *
 * Protokollfreie URLs (welche, die mit // beginnen), werden automatisch mit dem korrekten Protokoll ergänzt.
 * In diesem Fall wird auch ein SSL-Umschalt-Button im Header angezeigt
 */
if($_SERVER['HTTP_HOST'] = 'localhost')
{
	// keine Konfiguration -> BASEURL wird automatisch erraten
}
// if($_SERVER['HTTP_HOST'] = 'pre.stream.c3voc.de')
// {
// 	// Preview-Domain
// 	$GLOBALS['CONFIG']['BASEURL'] = '//pre.stream.c3voc.de/';
// }
else
{
	// Save Default
	$GLOBALS['CONFIG']['BASEURL'] = '//streaming.media.ccc.de/';
}
