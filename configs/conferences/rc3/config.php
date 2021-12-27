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
	'STARTS_AT' => strtotime("2021-12-27 06:00"),


	/**
	 * Der Endzeitpunkt der Konferenz als Unix-Timestamp. Befinden wir uns danach, wird eine Danke-Und-Kommen-Sie-
	 * Gut-Nach-Hause-Seite sowie einem Ausblick auf die kommenden Events angezeigt.
	 *
	 * Wird dieser Zeitpunkt nicht angegeben, endet die Konferenz nie. (Siehe aber CLOSED weiter unten)
	 */
	'ENDS_AT' => strtotime("2021-12-31 03:00"),

	/**
	 * Hiermit kann die Funktionalitaet von STARTS_AT/ENDS_AT überschrieben werden. Der Wert 'before'
	 * simuliert, dass die Konferenz noch nicht begonnen hat. Der Wert 'after' simuliert, dass die Konferenz
	 * bereits beendet ist. 'running' simuliert eine laufende Konferenz.
	 *
	 * Der Boolean true ist aus Abwärtskompatibilitätsgründen äquivalent zu 'after'. False ist äquivalent
	 * zu 'running'.
	 */
	// 'CLOSED' => 'before',

	/**
	 * Titel der Konferenz (kann Leer- und Sonderzeichen enthalten)
	 * Dieser im Seiten-Header, im <title>-Tag, in der About-Seite und ggf. ab weiteren Stellen als
	 * Anzeigetext benutzt
	 */
	'TITLE' => 'rC3 NOWHERE', 

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
	'DESCRIPTION' => 'Live streaming from the Remote Chaos Experience',

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
	'RELEASES' => 'https://media.ccc.de/c/rc3-2021',

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
	'RELIVE_JSON' => 'https://cdn.c3voc.de/relive/rc3-2021/index.json',
	/**
	 * APCU-Cache-Zeit in Sekunden
	 * Wird diese Zeile auskommentiert, werden die apc_*-Methoden nicht verwendet und
	 * das Relive-Json bei jedem Request von der Quelle geladen und geparst
	 */
	//'RELIVE_JSON_CACHE' => 30*60,

	//'ADDITIONAL_LICENCE_HTML' => 'Some sound effects and music obtained from <a href="https://www.zapsplat.com">zapsplat.com</a>',
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
		// TODO sort array in random order, based on current hour or simular
		'Channels' => array(
			'cbase',
			'cwtv',
			'r3s',
			'csh',
			'chaoszone',
			'fem',
			'franconiannet',
			'aboutfuture',
			'sendezentrum',
			'haecksen',
			'gehacktesfromhell',
			'xhain',
		),
		'Info' => array(
			'infobeamer'
		),
		'Music' => array(
			'c3lounge',
			'abchillgleis'
		),
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
	'URL' => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rC3-%s',
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
 * Globaler Schalter für die Raum Infos
 *
 * Wird diese Zeile auskommentiert oder auf False gesetzt, werden alle
 * Raum Infos deaktiviert.
 */
$CONFIG['INFO'] = true;


/**
 * Liste der Räume (= Audio & Video Produktionen, also auch DJ-Sets oä.)
 */
$CONFIG['ROOMS'] = array(
	/**
	 * Array-Key ist der Raum-Slug, der z.B. auch zum erstellen der URLs,
	 * in $CONFIG['OVERVIEW'] oder im Feedback verwendet wird.
	 */
	'c3lounge' => array(
		'DISPLAY' => 'rC3 Lounge',
		'DISPLAY_SHORT' => 'Lounge',
		'WIDE' => true,

		'STREAM' => 'c3lounge',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'rC3 Lounge',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-lounge @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-lounge',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3lounge @ mastodon/twitter',
			'TEXT'    => '#rC3lounge',
		),
		'INFO' => '',
	),
	'abchillgleis' => array(
		'DISPLAY' => 'Abchillgleis',
		'DISPLAY_SHORT' => 'Abchillgleis',
		'WIDE' => false,

		'STREAM' => 'abchillgleis',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Abchillgleis',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-lounge @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-lounge',
		),
		'TWITTER' => false,
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
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'c-base',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-cbase @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-cbase',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3cbase @ mastodon/twitter',
			'TEXT'    => '#rC3cbase',
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
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'ChaosZone TV',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-chaoszone @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-chaoszone',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3chaoszone @ mastodon/twitter',
			'TEXT'    => '#rC3chaoszone',
		),
	),
	'csh' => array(
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
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Chaosstudio Hamburg',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-chaosstudio-hamburg @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-chaosstudio-hamburg',
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
		'STREAM' => 'cwtv',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Chaos-West TV',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-cwtv @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-cwtv',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3cwtv @ mastodon/twitter',
			'TEXT'    => '#rC3cwtv',
		),
	),
	'franconiannet' => array(
		'DISPLAY' => 'franconian.net',
		'DISPLAY_SHORT' => 'franconian',
		'STREAM' => 'franconiannet',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
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
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-franconiannet',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3franconiannet @ mastodon/twitter',
			'TEXT'    => '#rC3franconiannet',
		),
	),
	'aboutfuture' => array(
		'DISPLAY' => 'about:future',
		'DISPLAY_SHORT' => 'a:f',
		'STREAM' => 'aboutfuture',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'about:future stage',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-aboutfuture @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-aboutfuture',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3af @ mastodon/twitter',
			'TEXT'    => '#rC3af',
		),
	),
	'lukas' => array(
		'DISPLAY' => 'Lukas Premium Test Stream',
		'DISPLAY_SHORT' => 'LUKAS',
		'STREAM' => 'lukas',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'lukas - Premium',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'IRC_CONFIG' => array(),
		'TWITTER' => false,
		'TWITTER_CONFIG' => array(),
	),
	'derchris' => array(
		'DISPLAY' => 'C3VOC Ping Pong',
		'DISPLAY_SHORT' => 'DERCHRIS',
		'STREAM' => 'derchris',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => '',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => false,
		'IRC_CONFIG' => array(),
		'TWITTER' => false,
		'TWITTER_CONFIG' => array(),
	),
	'r3s' => array(
		'DISPLAY' => 'Remote Rhein Ruhr Stage',
		'DISPLAY_SHORT' => 'R3S',
		'STREAM' => 'r3s',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'r3s - Monheim/Rhein',
		'ROOM_GUID' => 'f91f4af4-b667-4705-9aab-5c280177bf49',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-r3s @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-r3s',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3r3s @ mastodon/twitter',
			'TEXT'    => '#rC3r3s',
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
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Sendezentrum Bühne',
		'ROOM_GUID' => 'd1915b0a-6d9d-47f0-b9e8-3c00ab62e2fe',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-sendezentrum @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-sendezentrum',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3sz @ mastodon/twitter',
			'TEXT'    => '#rC3sz',
		),
	),

	'haecksen' => array(
		'DISPLAY' => 'Haecksen',
		'DISPLAY_SHORT' => 'haecksen',
		'STREAM' => 'haecksen',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Haecksen Stream',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-haecksen @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-haecksen',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3haecksen @ mastodon/twitter',
			'TEXT'    => '#rC3haecksen',
		),
	),

	'gehacktesfromhell' => array(
		'DISPLAY' => 'Gehacktes from Hell / Bierscheune',
		'DISPLAY_SHORT' => 'Hell',
		'STREAM' => 'gehacktes',
		'PREVIEW' => true,
		'TRANSLATION' => [
			['endpoint' => 'translated',   'label' => 'Translated1'],
			['endpoint' => 'translated-2', 'label' => 'Translated2']
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Bierscheune',
		'ROOM_GUID' => 'e5d65c11-3c4e-418c-aebe-4fc7a655176b',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-gehacktesfromhell @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-haecksen',
		),
			'TWITTER' => true,
			'TWITTER_CONFIG' => array(
				'DISPLAY' => '#rC3hell @ mastodon/twitter',
				'TEXT'    => '#rC3hell',
			),
	),

	'xhain' => array(
		'DISPLAY' => 'xHain Lichtung',
		'DISPLAY_SHORT' => 'xHain',
		'STREAM' => 'xhain',
		'PREVIEW' => true,
		'TRANSLATION' => [
		],

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'Lichtung',
		'ROOM_GUID' => '',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-xhain @ hackint',
			'URL'     => 'https://webirc.hackint.org/#ircs://irc.hackint.org/#rc3-xhain',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3xhain @ mastodon/twitter',
			'TEXT'    => '#rC3xhain',
		),
	),

	'fem' => array(
		'DISPLAY' => 'FeM',
		'DISPLAY_SHORT' => 'FeM',
		'STREAM' => 'fem',
		'PREVIEW' => true,

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'SCHEDULE_NAME' => 'FeM Channel',
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),

	'test' => array(
		'DISPLAY' => 'Test',
		'DISPLAY_SHORT' => 'Test',
		'STREAM' => 'test',
		'PREVIEW' => true,

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
	),
	'infobeamer' => array(
		'WIDE' => true,
		'DISPLAY' => 'Infobeamer',
		'DISPLAY_SHORT' => 'Infobeamer',
		'STREAM' => 'infobeamer',
		'PREVIEW' => true,

		'SD_VIDEO' => true,
		'HD_VIDEO' => true,
		'DASH' => true,
		'H264_ONLY' => true,
		'HLS' => true,
		'AUDIO' => true,
		'SLIDES' => false,
		'MUSIC' => false,
		'SCHEDULE' => true,
		'EMBED' => true,
		'IRC' => false,
		'TWITTER' => false,
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
	'URL' => 'https://data.c3voc.de/rC3_21/channels.schedule.xml',

	/**
	 * Nur die angegebenen Räume aus dem Fahrplan beachten
	 *
	 * Wird diese Zeile auskommentiert, werden alle Räume angezeigt
	 */
	//'ROOMFILTER' => array('rC3 Lounge', 'Bitwäscherei Zürich', 'ChaosTrawler', 'xHain Berlin'),

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
	// 'SIMULATE_OFFSET' => strtotime(/* Conference-Date */ '2021-12-27') - strtotime(/* Today */ date("Y-m-d")),
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

	'everything.schedule.xml' => 'http://data.c3voc.de/rC3_21/everything.schedule.xml',
	'everything.schedule.json' => 'http://data.c3voc.de/rC3_21/everything.schedule.json',

	//'stages.schedule.xml' => 'http://data.c3voc.de/36C3/stages.schedule.xml',
	//'stages.schedule.json' => 'http://data.c3voc.de/36C3/stages.schedule.json',

	//'wiki.schedule.xml' => 'http://data.c3voc.de/36C3/wiki.schedule.xml',
	//'wiki.schedule.json' => 'http://data.c3voc.de/36C3/wiki.schedule.json',

	//'workshops.schedule.xml' => 'http://data.c3voc.de/36C3/workshops.schedule.xml',
	//'workshops.schedule.json' => 'http://data.c3voc.de/36C3/workshops.schedule.json',
);


return $CONFIG;
