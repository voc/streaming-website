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
						'irc' => lowerCaseKeys($conference->get('IRC', false)),
						'twitter' => lowerCaseKeys($conference->get('TWITTER', false)),
					),
				),
				'schedule' => lowerCaseKeys($conference->get('SCHEDULE')),
				'overviewPage' => array(
					'sections' => formatSections($conference->get('OVERVIEW.GROUPS')),
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
		$struct[] = array(
			'name' => $room->getDisplay(),
			'slug' => $room->getSlug(),
			'streamId' => $room->getStream(),
			'streamingConfig' => lowerCaseKeys($config),
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
