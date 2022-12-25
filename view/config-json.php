<?php

header('Content-Type: application/json');

function formatConference($conference) {
	return array(
		'conference' => array(
			'title' => $conference->getTitle(),
			'acronym' => $conference->getSlug(),
			'organizer' => $conference->getAuthor(),
			'description' => $conference->getDescription(),
			'keywords' => $conference->hasKeywords() ? preg_split('/,\s*/', $conference->getKeywords()) : null,
			'start' => $conference->startsAt() ? $conference->startsAt()->format('c') : null,
			'end' => $conference->endsAt() ? $conference->endsAt()->format('c') : null,
			'streamingConfig' => array(
				//'closed' => null,
				//'unlisted' => $conference->isUnlisted(),
				'features' => array(
					'embed' => $conference->get('EMBED', false),
					'relive' => $conference->hasRelive(),
					'feedback' => $conference->hasFeedback(),
					'chat' => array(
						'irc' => lowerCaseKeys($conference->get('IRC', null)),
						'twitter' => lowerCaseKeys($conference->get('TWITTER', null)),
					),
				),
				'schedule' => lowerCaseKeys($conference->get('SCHEDULE')),
				'overviewPage' => array(
					'sections' => formatSections($conference->get('OVERVIEW.GROUPS', [])),
				),
				'html' => array(
					'banner' => $conference->getBannerHtml(),
					'footer' => $conference->getFooterHtml(),
					'not_started' => $conference->getNotStartedHtml(),
				),
				'extraFiles' => $conference->get('EXTRA_FILES'),
			),
			'rooms' => formatRooms($conference),
		),
	);
}

function formatRooms($conference) {
	$struct = [];

	foreach($conference->getRooms() as $room) {
		$config = $conference->get('ROOMS.'.$room->getSlug());

		// cleanup nested config from config.json input
		unset($config['streamingConfig']);
		unset($config['stream']);
		unset($config['streamId']);
		unset($config['guid']);
		unset($config['name']);
		unset($config['slug']);
		foreach ($config['chat'] as $k => $v) {
			unset($config[$k]);
		}


		$struct[] = array(
			'guid' => $room->getId(),
			'slug' => $room->getSlug(),
			'name' => $room->get('name') ?: $room->getScheduleName(),
			'stream' => $room->getStream(),
			'streamingConfig' => $config ? lowerCaseKeys($config) : null,
		);
	}
	return $struct;
}

function formatSections($pageConfig) {
	$struct = [];

	foreach($pageConfig as $sectionTitle => $items)
	{
		$section = array(
			'title' => $sectionTitle,
			'items' => [], 
		);

		foreach($items as $item)
		{
			$section['items'][] = array(
				'slug' => $item,
			);
		}
		$struct[] = $section;
	}	
	return $struct;
}

function lowerCaseKeys($config)
{
	if (empty($config)) {
		return null;
	}

	// if config is an object, the keys are already in the proper format
	if (is_object($config)) {
		return (array) $config;
	}

	return array_map(function($item) {
		return is_array($item) ? lowerCaseKeys($item) : $item;
	}, array_change_key_case($config));
}

if (!empty($conference)) {
	$struct = formatConference($conference);
}
else {
	$struct = [];
	foreach (Conferences::getActiveConferences() as $conference)
	{
		$struct[] = formatConference($conference);
	}
}
echo json_encode($struct, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
