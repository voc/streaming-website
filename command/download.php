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

foreach (Conferences::getConferences() as $conference)
{
	stdout('== %s ==', $conference->getSlug());

	if(isset($conf['MAX_CONFERENCE_AGE']))
	{
		date_diff()
		return time() >= $this->endsAt();
	}

}
