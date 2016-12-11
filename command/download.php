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
		download(
			'relive-json',
			$conference,
			$relive->getJsonUrl(),
			$relive->getJsonCache()
		);
	}

	$schedule = $conference->getSchedule();
	if($schedule->isEnabled())
	{
		download(
			'schedule-xml',
			$conference,
			$schedule->getScheduleUrl(),
			$schedule->getScheduleCache()
		);
	}

	foreach($conference->getExtraFiles() as $file)
	{
		download(
			'extra-file',
			$conference,
			$file,
			get_file_cache($conference, $file)
		);
	}
}




function get_file_cache($conference, $url)
{
	$info = parse_url($url);
	$host = trim(preg_replace('/[^a-z0-9]/i', '_', $info['host']), '_');
	$path = trim(preg_replace('/[^a-z0-9]/i', '_', $info['path']), '_');
	return sprintf('/tmp/file-cache-%s_%s_%s-%s', $conference->getSlug(), $host, $path, md5($url));
}

function download($what, $conference, $url, $cache)
{
	stdout(
		'  downloading %s from %s to %s',
		$what,
		$url,
		$cache
	);
	if(!do_download($url, $cache))
	{
		stderr(
			'!! download %s for conference %s from %s to %s failed miserably !!',
			$what,
			$conference->getSlug(),
			$url,
			$cache
		);
	}
}

function do_download($url, $cache)
{
	return true;
}
