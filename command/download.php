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

	stdout('Skipping Conferences before %s', $conferencesAfter->format('Y-m-d'));
	$conferences = array_filter($conferences, function($conference) use ($conferencesAfter) {
		if($conference->isOpen())
		{
			stdout(
				'  %s: %s',
				'---open---',
				$conference->getSlug()
			);

			return true;
		}

		if($conference->endsAt() == null)
			return false;

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

	$relive = $conference->getRelive();
	if($relive->isEnabled())
	{
		download_for_conference(
			'relive-json',
			$conference,
			$relive->getJsonUrl(),
			$relive->getJsonCache()
		);
	}

	$schedule = $conference->getSchedule();
	if($schedule->isEnabled())
	{
		download_for_conference(
			'schedule-xml',
			$conference,
			$schedule->getScheduleUrl(),
			$schedule->getScheduleCache()
		);
	}

	foreach($conference->getExtraFiles() as $filename => $url)
	{
		download_for_conference(
			'extra-file',
			$conference,
			$url,
			get_file_cache($conference, $filename)
		);
	}
}

stdout('');
stdout('== eventkalender ==');
download(
	'eventkalender',
	'https://c3voc.de/eventkalender/events.json?filter=upcoming&streaming=yes',
	joinpath([$GLOBALS['BASEDIR'], 'configs/upcoming.json'])
);





function get_file_cache($conference, $filename)
{
	return joinpath([$GLOBALS['BASEDIR'], 'configs/conferences', $conference->getSlug(), $filename]);
}

function download_for_conference($what, $conference, $url, $cache)
{
	$info = parse_url($url);
	if(!isset($info['scheme']) || !isset($info['host']))
	{
		stderr(
			'  !! %s url for conference %s does look like an old-style path: "%s". please update to a full http/https url',
			$what,
			$conference->getSlug(),
			$url
		);
		return false;
	}

	stdout(
		'  downloading %s from %s to %s',
		$what,
		$url,
		$cache
	);
	$resp = do_download($url, $cache);
	if($resp !== true)
	{
		stderr(
			'  !! download %s for conference %s from %s to %s failed miserably: %s !!',
			$what,
			$conference->getSlug(),
			$url,
			$cache,
			$resp
		);
	}
	return true;
}

function download($what, $url, $cache)
{
	stdout(
		'  downloading %s from %s to %s',
		$what,
		$url,
		$cache
	);
	$resp = do_download($url, $cache);
	if($resp !== true)
	{
		stderr(
			'  !! download %s from %s to %s failed miserably: %s !!',
			$what,
			$url,
			$cache,
			$resp
		);
	}
	return true;
}
