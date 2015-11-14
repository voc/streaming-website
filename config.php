<?php

date_default_timezone_set('Europe/Berlin');

/**
 * Während der Entwicklung wird die BASEURL automatisch erraten
 * In Produktionssituationen sollte manuell eine konfiguriert werden um Überraschungen zu vermeiden
 *
 * Protokollfreie URLs (welche, die mit // beginnen), werden automatisch mit dem korrekten Protokoll ergänzt.
 * In diesem Fall wird auch ein SSL-Umschalt-Button im Header angezeigt
 */
if($_SERVER['HTTP_HOST'] != 'localhost')
	$GLOBALS['CONFIG']['BASEURL'] = '//streaming.media.ccc.de/';
