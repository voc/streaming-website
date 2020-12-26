<?php

$CONFIG['CONFERENCE'] = array(
	/**
	 * Der Startzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns davor, wird die Closed-Seite
	 * mit einem Text der Art "hat noch nicht angefangen" angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, gilt die Konferenz immer als angefangen. (Siehe aber ENDS_AT
	 * und CLOSED weiter unten)
	 */
	//'STARTS_AT' => strtotime("2020-11-27 06:00"),
	'STARTS_AT' => strtotime("2020-12-27 06:00"),


	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2020-12-30 20:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	'CLOSED' => 'running',

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'RC3 Test', # TODO

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
	'DESCRIPTION' => 'Live streaming from the Remote Communication Experience',

	/**
	 * Schlüsselwortliste, Kommasepariert
	 * Wird für den <meta name="keywords">-Tag verdet. Wird diese Zeile auskommentiert, wird kein solcher
	 * <meta>-Tag generiert.
	 */
	'KEYWORDS' => 'rC3, Hacking, Chaos Computer Club, Video, Music, Podcast, Media, Streaming, Hacker, Internet',

	/**
	 * HTML-Code für den Footer (z.B. für spezielle Attribuierung mit <a>-Tags)
	 * Sollte üblicherweise nur Inline-Elemente enthalten
	 * Wird diese Zeile auskommentiert, wird die Standard-Attribuierung für (c3voc.de) verwendet
	 */
	'FOOTER_HTML' => '
		by <a href="https://ccc.de">Chaos Computer Club e.V</a>,
		<a href="https://fem.tu-ilmenau.de/">FeM</a> &
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
	/** 'BANNER_HTML' => '<img src="../configs/conferences/fiffkon16/logo.png" class="FIfFKon">', **/
	// 'BANNER_HTML' => '<div class="congress"></div><div class="congress-motto"></div>',

	/**
	 * Link zu den Recordings
	 * Wird diese Zeile auskommentiert, wird der Link nicht angezeigt
	 */
	'RELEASES' => 'https://media.ccc.de/c/rc3',

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
	'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/rc3/index.json',
	/**
	 * APCU-Cache-Zeit in Sekunden
	 * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
	 * das Relive-Json bei jedem Request von der Quelle geladen und geparst
	 */
	//'RELIVE_JSON_CACHE' => 30*60,

	'ADDITIONAL_LICENCE_HTML' => 'Some sound effects and music obtained from <a href="https://www.zapsplat.com">zapsplat.com</a>',
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
			'one',
			'two',
		),
		'Assemblies Live' => array(
			'bitwaescherei',
			'cbase',
			'chaosstudio-hamburg',
			'chaostrawler',
			'chaoszone',
			'cwtv',
			'franconiannet',
			'hacc',
			'kreaturworks',
			'oio',
			'r3s',
			'restrealitaet',
			'sendezentrum',
			'wikipaka',
			'xhain',
			'c3lounge',
			'infobeamer',
			'test',
		),
		// 'Music' => array()
	),
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
	'DISPLAY' => '#rC3-%s @ hackint',

	/**
	 * URL für die IRC-Links.
	 * Hierbei kann sowohl ein irc://-Link als auch ein Link zu einem
	 * WebIrc-Provider wie z.B. 'https://kiwiirc.com/client/irc.hackint.eu/#33C3-%s'
	 * verwendet werden.
	 *
	 * %s wird durch den urlencodeten Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'URL' => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rC3-%s',
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
	'DISPLAY' => '#rC3%s @ mastodon/twitter',

	/**
	 * Vorgabe-Tweet-Text für die Twitter-Links.
	 *
	 * %s wird durch den Raum-Slug ersetzt.
	 * Eine Anpassung kann ebenfalls in der Raum-Konfiguration vorgenommen werden.
	 */
	'TEXT' => '#rC3%s',
);

/**
 * Globaler Schalter für die Embedding-Funktionalitäten
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Embedding-Funktionen deaktiviert.
 */
$CONFIG['EMBED'] = true;


/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	/**
	 * Array-Key ist der Raum-Slug, der z.B. auch zum erstellen der URLs,
	 * in $CONFIG['OVERVIEW'] oder im Feedback verwendet wird.
	 */
	'one' => array(
		'DISPLAY' => 'rC1',
		'WIDE' => true,
		'STREAM' => 's1',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],
		
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => true,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'rC1',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 1,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rC3-one @ hackint',
			'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rC3-one',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3one @ mastodon/twitter',
			'TEXT'    => '#rC3one',
		),
	),
	'two' => array(
		'DISPLAY' => 'rC2',
		'WIDE' => true,
		'STREAM' => 's2',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],
		
		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'SLIDES' => true,
		'DASH' => true,
		'AUDIO' => true,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'rC2',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'SUBTITLES_ROOM_ID' => 2,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rC3-two @ hackint',
			'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rC3-two',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3two @ mastodon/twitter',
			'TEXT'    => '#rC3two',
		),
	),
	'bitwaescherei' => array(
			'DISPLAY' => 'Bitwäscherei',
			'DISPLAY_SHORT' => 'Bitwäscherei',
			'STREAM' => 'bitwaescherei',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'Bitwäscherei Zürich',
			'ROOM_GUID' => '2c5f8217-8583-45ef-ab10-fa2ff5492d19',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-bitwaescherei @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-bitwaescherei',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3bitwaescherei @ mastodon/twitter',
				'TEXT'    => '#rC3bitwaescherei',
			),
	),
	'c3lounge' => array(
			'DISPLAY' => 'Lounge',
			'DISPLAY_SHORT' => 'Lounge',
			'STREAM' => 'c3lounge',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'rc3 Lounge',
			'ROOM_GUID' => '',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-lounge @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-lounge',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3lounge @ mastodon/twitter',
				'TEXT'    => '#rC3lounge',
			),
	),
	'cbase' => array(
			'DISPLAY' => 'c-base',
			'DISPLAY_SHORT' => 'c-base',
			'STREAM' => 'cbase',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'c-base Berlin',
			'ROOM_GUID' => '4d0ff1b8-60f9-4195-8efb-c506983a33d4',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-cbase @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-cbase',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3cbase @ mastodon/twitter',
				'TEXT'    => '#rC3cbase',
			),
	),
	'chaostrawler' => array(
			'DISPLAY' => 'ChaosTrawler Stubnitz/Gängeviertel',
			'DISPLAY_SHORT' => 'chaostrawler',
			'STREAM' => 'chaostrawler',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'ChaosTrawler',
			'ROOM_GUID' => 'd736ad8f-29ec-4a02-811e-9877798437ba',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => false,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-chaostrawler @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-chaostrawler',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#chaostrawler @ mastodon/twitter',
				'TEXT'    => '#chaostrawler',
			),
	),
	'chaoszone' => array(
			'DISPLAY' => 'ChaosZone TV',
			'DISPLAY_SHORT' => 'CZTV',
			'STREAM' => 'chaoszone',
			'PREVIEW' => true,
			'TRANSLATION' => [
				['endpoint' => 'translated',   'label' => 'Translated1'],
				['endpoint' => 'translated-2', 'label' => 'Translated2']
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'ChaosZone TV Stream',
			'ROOM_GUID' => '084fed6f-8da2-4870-b8c2-7a2b1dce88bd',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-chaoszone @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-chaoszone',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3chaoszone @ mastodon/twitter',
				'TEXT'    => '#rC3chaoszone',
			),
	),
	'chaosstudio-hamburg' => array(
			'DISPLAY' => 'ChaosStudio Hamburg',
			'DISPLAY_SHORT' => 'CSH',
			'STREAM' => 'csh',
			'PREVIEW' => true,
			'TRANSLATION' => [
				['endpoint' => 'translated',   'label' => 'Translated1'],
				['endpoint' => 'translated-2', 'label' => 'Translated2']
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'chaosstudio-hamburg',
			'ROOM_GUID' => 'ebc42052-10f7-4aef-bbe9-cfe9026880cc',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-csh @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-csh',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3csh @ mastodon/twitter',
				'TEXT'    => '#rC3csh',
			),
	),
	'cwtv' => array(
			'DISPLAY' => 'Chaos-West TV',
			'DISPLAY_SHORT' => 'CWTV',
			'STREAM' => 'cwtv2',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'Chaos-West TV',
			'ROOM_GUID' => '48f5bce3-5b46-44d8-9f36-90bed9bd4be0',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-cwtv @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-cwtv',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3cwtv @ mastodon/twitter',
				'TEXT'    => '#rC3cwtv',
			),
	),
	'franconiannet' => array(
			'DISPLAY' => 'franconian.net',
			'DISPLAY_SHORT' => 'backspace',
			'STREAM' => 'franconiannet',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'franconian.net',
			'ROOM_GUID' => '',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-franconiannet @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-franconiannet',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3franconiannet @ mastodon/twitter',
				'TEXT'    => '#rC3franconiannet',
			),
	),
	'hacc' => array(
			'DISPLAY' => 'about:future',
			'DISPLAY_SHORT' => 'hacc/a:f',
			'STREAM' => 'hacc',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'hacc München / about:future',
			'ROOM_GUID' => '60dd7f55-9f88-4de6-ad98-b9c4e2810300',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-hacc @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-hacc',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3hacc @ mastodon/twitter',
				'TEXT'    => '#rC3hacc',
			),
	),
	'kreaturworks' => array(
			'DISPLAY' => 'KreaturWorks',
			'DISPLAY_SHORT' => 'KreaturWorks',
			'STREAM' => 'kreaturworks',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'KreaturWorks',
			'ROOM_GUID' => 'd19c8dcf-b0ef-41ef-aca0-588675d3e138',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-kreaturworks @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-kreaturworks',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3kreaturworks @ mastodon/twitter',
				'TEXT'    => '#rC3kreaturworks',
			),
	),
	'oio' => array(
			'DISPLAY' => 'OpenInfrastructureOrbit',
			'DISPLAY_SHORT' => 'OIO',
			'STREAM' => 'oio',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'OIO/A:F Bühne',
			'ROOM_GUID' => 'c7eb387e-2af1-4129-859b-85abc7ae1a0e',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-oio @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-oio',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3OIO @ mastodon/twitter',
				'TEXT'    => '#rC3OIO',
			),
	),
	'r3s' => array(
			'DISPLAY' => 'Remote Rhein Ruhr Stage',
			'DISPLAY_SHORT' => 'R3S',
			'STREAM' => 'r3s',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'r3s - Monheim/Rhein',
			'ROOM_GUID' => 'c4a577e2-52e7-4f6f-a5c0-e3822d64f84a',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-r3s @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-r3s',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3r3s @ mastodon/twitter',
				'TEXT'    => '#rC3r3s',
			),
	),
	'restrealitaet' => array(
			'DISPLAY' => 'Restrealitaet',
			'DISPLAY_SHORT' => 'Restrealitaet',
			'STREAM' => 'restrealitaet',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'restrealitaet',
			'ROOM_GUID' => '29f5ea95-2cb1-43bf-b3ea-83674646334d',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-restrealitaet @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-restrealitaet',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3restrealitaet @ mastodon/twitter',
				'TEXT'    => '#rC3restrealitaet',
			),
	),
	'sendezentrum' => array(
			'DISPLAY' => 'Sendezentrum',
			'DISPLAY_SHORT' => 'Sendezentrum',
			'STREAM' => 'sendezentrum',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => "SZ Bühne",
			'ROOM_GUID' => 'feb91cb1-eb66-43f1-a86f-f8d43909fbe0',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-sendezentrum @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-sendezentrum',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3sz @ mastodon/twitter',
				'TEXT'    => '#rC3sz',
			),
	),
	'wikipaka' => array(
			'DISPLAY' => 'Wikipaka',
			'DISPLAY_SHORT' => 'WikiPaka',
			'STREAM' => 'wikipaka',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'Wikipaka',
			'ROOM_GUID' => '',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-wikipaka @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-wikipaka',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3wikipaka @ mastodon/twitter',
				'TEXT'    => '#rC3wikipaka',
			),
	),
	'xhain' => array(
			'DISPLAY' => 'xHain',
			'DISPLAY_SHORT' => 'xHain',
			'STREAM' => 'xhain',
			'PREVIEW' => true,
			'TRANSLATION' => [
			],

			'SD_VIDEO' => true,
			'HD_VIDEO' => true,
			'DASH' => true,
			'HLS' => true,
			'AUDIO' => true,
			'SLIDES' => false,
			'MUSIC' => false,
			'SCHEDULE' => true,
			'SCHEDULE_NAME' => 'xhain Berlin',
			'ROOM_GUID' => '',
			'FEEDBACK' => true,
			'SUBTITLES' => false,
			'EMBED' => true,
			'IRC' => true,
			'IRC_CONFIG' => array(
				'DISPLAY' => '#rc3-xhain @ hackint',
				'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-xhain',
			),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3xhain @ mastodon/twitter',
				'TEXT'    => '#rC3xhain',
			),
	),

	'infobeamer' => array(
		'DISPLAY' => 'Infobeamer',
		'DISPLAY_SHORT' => 'Infobeamer',
		'STREAM' => 'infobeamer',
		'PREVIEW' => true,

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),

	'test' => array(
		'DISPLAY' => 'Test',
		'DISPLAY_SHORT' => 'Test',
		'STREAM' => 's80',
		'PREVIEW' => true,

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bühne',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => 'rC3-test @ mastodon/twitter',
			'TEXT'    => 'rC3-test',
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
	'URL' => 'https://data.c3voc.de/rC3/channels.schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
	//'ROOMFILTER' => array('Ada', 'Borg', 'Clarke', 'Dijkstra', 'Eliza',
	//	'WikiPaka WG: Esszimmer', 'Chaos-West Bühne', 'OIO Stage', 'DLF- und Podcast-Bühne'),

	/**
	 * Skalierung der Programm-Vorschau in Sekunden pro Pixel
	 */
	'SCALE' => 6,

	/**
	 * Simuliere das Verhalten als wäre die Konferenz bereits heute
	 *
	 * Diese folgende Beispiel-Zeile Simuliert, dass das
	 * Konferenz-Datum 2014-12-29 auf den heutigen Tag 2015-02-24 verschoben ist.
	 */
	'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2020-12-27') - strtotime(/* Today */ date("Y-m-d")),
	//'SIMULATE_OFFSET' => 0,
);

/*
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
 * Liste zusätzlich herunterzuladender Dateien
 *
 * Dict mit dem Dateinamen im Key und einer URL im Value. Die Dateien werden
 * unter dem angegebenen Dateinamen in diesem Konfigurationsordner abgelegt.
 */
$CONFIG['EXTRA_FILES'] = array(
	//'schedule.xml'  => 'https://fahrplan.events.ccc.de/congress/2019/Fahrplan/schedule.xml',
	//'schedule.json' => 'https://fahrplan.events.ccc.de/congress/2019/Fahrplan/schedule.json',
	//'schedule.ics'  => 'https://fahrplan.events.ccc.de/congress/2019/Fahrplan/schedule.ics',
	//'schedule.xcal' => 'https://fahrplan.events.ccc.de/congress/2019/Fahrplan/schedule.xcal',

	'everything.schedule.xml' => 'http://data.c3voc.de/rC3/everything.schedule.xml',
	'everything.schedule.json' => 'http://data.c3voc.de/rC3/everything.schedule.json',

	//'stages.schedule.xml' => 'http://data.c3voc.de/36C3/stages.schedule.xml',
	//'stages.schedule.json' => 'http://data.c3voc.de/36C3/stages.schedule.json',

	//'wiki.schedule.xml' => 'http://data.c3voc.de/36C3/wiki.schedule.xml',
	//'wiki.schedule.json' => 'http://data.c3voc.de/36C3/wiki.schedule.json',

	//'workshops.schedule.xml' => 'http://data.c3voc.de/36C3/workshops.schedule.xml',
	//'workshops.schedule.json' => 'http://data.c3voc.de/36C3/workshops.schedule.json',
);


return $CONFIG;
