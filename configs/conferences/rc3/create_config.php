<?php

$query = '{channels{nodes{name,slug,url:schedule_url,schedule_room,room_guid}}}';
$data = json_decode(file_get_contents('https://c3voc.de/wiki/lib/exe/graphql2.php?query='.$query), true)['data'];
$channels = $data['channels']['nodes'];

foreach ( $channels as $c ) {
	$schedule_name = $c['schedule_room'] ?: $c['name'];

	echo <<<EOT
	'$c[slug]' => array(
		'DISPLAY' => '$c[name]',
		'DISPLAY_SHORT' => '$c[name]',
		'STREAM' => '$c[slug]',
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
		'SCHEDULE_NAME' => '$schedule_name',
		'ROOM_GUID' => '$c[room_guid]',
		'FEEDBACK' => true,
		'SUBTITLES' => false,
		'EMBED' => true,
		'IRC' => true,
		'IRC_CONFIG' => array(
			'DISPLAY' => '#rc3-$c[slug] @ hackint',
			'URL'     => 'https://webirc.hackint.org/#irc://irc.hackint.org/#rc3-$c[slug]',
		),
		'TWITTER' => true,
		'TWITTER_CONFIG' => array(
			'DISPLAY' => '#rC3-$c[slug] @ mastodon/twitter',
			'TEXT'    => '#rC3-$c[slug]',
		),
	),

EOT;
}