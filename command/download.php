<?php

$conf = $GLOBALS['CONFIG']['DOWNLOAD'];

if(isset($conf['REQUIRE_USER']))
{
	if(get_current_user() != $conf['require-user'])
	{
		stderr(
			'Not downloading files for user %s, run this script as user %s',
			get_current_user(),
			$conf['require-user']
		);
		exit(2);
	}
}

$conferences = Conferences::getConferences();

if(isset($conf['MAX_CONFERENCE_AGE']))
{
	$months = intval($conf['MAX_CONFERENCE_AGE']);
	$conferencesAfter = new DateTime();
	$conferencesAfter->sub(new DateInterval('P'.$months.'D'));

	stdout('Filtering before %s', $conferencesAfter->format('Y-m-d'));
	$conferences = array_filter($conferences, function($conference) use ($conferencesAfter) {
		$isBefore = $conference->endsAt() < $conferencesAfter;

		if($isBefore) {
			stdout(
				'  %s: %s',
				$conference->endsAt()->format('Y-m-d'),
				$conference->getSlug()
			);
		}

		return !$isBefore;
	});
}

stdout('');
foreach ($conferences as $conference)
{
	stdout('== %s ==', $conference->getSlug());
}
