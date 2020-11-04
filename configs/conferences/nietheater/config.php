<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	'STARTS_AT' => strtotime("2019-3-29 17:00"),

	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2019-3-30 02:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	/**'CLOSED' => 'after', */

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'NIE Theater - Aufstand der Huren',

	/**
	 * Veranstalter
	 * Wird für den <meta name="author">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'AUTHOR' => 'NIE Kollektiv',

	/**
	 * Beschreibungstext
	 * Wird für den <meta name="description">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'DESCRIPTION' => 'Gespielt im Keller der Karl-Marx-Str.58 in Neukölln und ausgewählten Orten in Berlin. Der Zuschauerraum ist in ebendiesem Keller sowie der Bar de la Plaine, Marseille auf der Terrasse von Mikis Theodorakis, Athen (nur mit pers. Einladung) und weiteren Orten in Berlin.

In Frankreich zerlegen Menschen aus der Provinz das reizende Paris. Von der Regierung erwarten sie viel, aber eben nichts Gutes. Zeitgleich herrscht in Berlin die Ordnung, die nicht nur die europäischen Nachbarn verarmen lässt, sondern auch die eigene Bevölkerung mit diskreten aber harten Mitteln aus ihren Wohnungen vertreibt und zu Arbeiten anstachelt, die immer weniger Sinn ergeben. Ein Lebensbereich nach dem anderen wird vermessen, mit einem Wert belegt und dann billig verscherbelt, wobei alle Orte, denen es nicht vorrangig ums Geldverdienen geht, verschwinden sollen.

„Ich mag Sex, aber ich will ihn nicht verkaufen. Auf jeden Fall nicht immer.“ Karl Lagerfeld

Darauf scheinen viele Leute schlicht keine Lust mehr zu haben. Das westliche Gesellschaftsmodell ist am Tiefpunkt seiner Glaubwürdigkeit angekommen. Aber was kann man schon machen? Oder: Was kann man noch machen?
Es wird auf jeden Fall nicht ausreichen, einzig mehr Honorar für seine Dienste zu verlangen. Die Herausforderung liegt vielmer darin, demokratisch auf der Bedingung von Gleichheit und Freiheit entscheiden zu können, was und wie produziert wird und dabei nicht hinter die bereits erreichten Freiheiten für die je Einzelne zurückzufallen.

„Öffentliche Anliegen verhandelt man am Besten in der Öffentlichkeit, alle anderen im Schlafzimmer.“ Wilde

Im Theater bilden wir kleine Gesellschaften aus, weil bei der Produktion unterschiedliche Tätigkeiten anfallen und Fähigkeiten benötigt werden. In Anbetracht der derzeit proklamierten Alternativlosigkeit ist dieser gesellschaftliche Aspekt nicht unwichtig. Mehr als dreißig Schauspieler und Technikerinnen, zwei handvoll lebende und tote Autoren und acht Regisseure bringen dieses Stück gemeinsam auf die Bühne.

Die Paranoia wuchert und an jeder einträglichen Straßenecke lauert der Verrat. Eine Bande Huren zieht knallhart einen Juwelenraub durch, ein korrupter Sherriff geht seinen Weg, Lili will Sim-Karten kaufen und irgendwas mit Beethoven. Erotikabenteuer in der langen Nacht Berlins.

Jeder hat die Möglichkeit seine persönlichen Interessen und Obsessionen zu verfolgen. Das ganze Stück wird mit der Kamera aufgezeichnet und an ausgewählten Orten in Berlin, Athen und Marseille übertragen. Die Stadt wird zur Bühne. Mit direkter Action & viel mehr Text als in Paris.',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'NIE, Theater',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		<a href="https://niekollektiv.de/">niekollektiv.de</a>
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
/*	'BANNER_HTML' => '
		<img src="../configs/conferences/pw18/logo3.png">
	',
*/

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 *
	 *'RELEASES' => 'https://media.ccc.de/c/pw18',
	 */

	/**
	 * Um die interne ReLive-Ansicht zu aktivieren, kann hier ein ReLive-JSON
	 * konfiguriert werden. Üblicherweise wird diese Datei über das Script
	 * configs/download.sh heruntergeladen, welches von einem Cronjob
	 * regelmäßig getriggert wird.
	 *
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/nietheater/index.json',
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
			'q2',
		),
	),
);



/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	'q2' => array(
		'DISPLAY' => 'q2',
		'STREAM' => 'q2',
		'PREVIEW' => true,

		'TRANSLATION' => false,
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,

		'SCHEDULE' => false,
		'SCHEDULE_NAME' => 'q2',
		'FEEDBACK' => false,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#pw18 @ twitter/mastodon',
			'TEXT'    => '#pw18',
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
	'URL' => 'https://cfp.privacyweek.at/pw18/schedule/export/schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
	'ROOMFILTER' => array('Saal 1', 'Saal 2', 'Workshop Raum'),

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 6,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2016-12-29 auf den heutigen Tag 2016-02-24 verschoben ist.
	 */
	//'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2018-10-23 11:00') - strtotime(/* Today */ date('Y-m-d')),
	//'SIMULATE_OFFSET' => 0,
);


/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;

/**
 * Globale Konfiguration der Twitter-Links.
 *
 * Wird dieser Block auskommentiert, werden keine Twitter-Links mehr erzeugt. Sollen die
 * Twitter-Links für jeden Raum einzeln konfiguriert werden, muss dieser Block trotzdem
 * existieren sein. ggf. einfach auf true setzen:
 *
 *   $CONFIG['TWITTER'] = true
 */
$CONFIG['TWITTER'] = true;

return $CONFIG;
