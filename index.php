<?php

if(!ini_get('short_open_tag'))
	die("`short_open_tag = On` is required\n");

$GLOBALS['BASEDIR'] = dirname(__FILE__);
chdir($GLOBALS['BASEDIR']);

require_once('config.php');
require_once('lib/helper.php');

require_once('lib/PhpTemplate.php');
require_once('lib/Exceptions.php');
require_once('lib/less.php/Less.php');

require_once('model/ModelBase.php');
require_once('model/Conferences.php');
require_once('model/Conference.php');
require_once('model/GenericConference.php');
require_once('model/Feedback.php');
require_once('model/Schedule.php');
require_once('model/Subtitles.php');
require_once('model/Overview.php');
require_once('model/Room.php');
require_once('model/RoomTab.php');
require_once('model/RoomSelection.php');
require_once('model/Stream.php');
require_once('model/Relive.php');
require_once('model/Upcoming.php');


ob_start();
if(isset($argv) && isset($argv[1]))
{
	require('lib/command-helper.php');

	switch($argv[1])
	{
		case 'download':
			require('command/download.php');
			exit(0);
	}

	stderr("Unknown Command: %s", $argv[1]);
	exit(1);
}


try {
	if(isset($_GET['htaccess']))
	{
		$route = @$_GET['route'];
	}
	elseif(isset($_SERVER["REQUEST_URI"]))
	{
		$route = ltrim(@$_SERVER["REQUEST_URI"], '/');

		// serve static
		if($route != '' && file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$route))
		{
			return false;
		}

	}
	else $route = '';


	$pieces = parse_url($route);
	$route = isset($pieces['path']) ? $pieces['path'] : '';
	$route = rtrim($route, '/');

	$GLOBALS['forceopen'] = isset($_GET['forceopen']);

	// generic template
	$tpl = new PhpTemplate('template/page.phtml');
	$tpl->set(array(
		'baseurl' => forceslash(baseurl()),
		'route' => $route,
		'canonicalurl' => forceslash(baseurl()).forceslash($route),
		'assemblies' => 'template/assemblies/',
		'assets' => forceslash('assets'),
		'conference_assets' => '',

		'conference' => new GenericConference(),
	));

	if(startswith('//', @$GLOBALS['CONFIG']['BASEURL']))
	{
		$tpl->set(array(
			'httpsurl' => forceslash(forceslash('https:'.$GLOBALS['CONFIG']['BASEURL']).@$GLOBALS['MANDATOR']).forceslash($route).url_params(),
			'httpurl' =>  forceslash(forceslash('http:'. $GLOBALS['CONFIG']['BASEURL']).@$GLOBALS['MANDATOR']).forceslash($route).url_params(),
		));
	}

	// GLOBAL ROUTES
	if($route == 'gen/main.css')
	{
		// global css (for conferences overview)
		handle_lesscss_request('assets/css/main.less', '../assets/css/');
		exit;
	}

	else if($route == 'streams/v1.json')
	{
		require('view/streams-json-v1.php');
		exit;
	}

	else if($route == 'streams/v2.json')
	{
		require('view/streams-json-v2.php');
		exit;
	}

	else if($route == 'config.json')
	{
		require('view/config-json.php');
		exit;
	}

	else if($route == 'about')
	{
		// global about-page
		require('view/about-global.php');
		exit;
	}

	@list($mandator, $route) = explode('/', $route, 2);
	if(!$mandator)
	{
		// root requested

		if(Conferences::getActiveConferencesCount() == 0)
		{
			// no clients
			//   error

			require('view/allclosed.php');
			exit;
		}
		else if(Conferences::getActiveConferencesCount() == 1)
		{
			// one client
			//   redirect

			$clients = Conferences::getActiveConferences();
			header('Location: '.joinpath([baseurl(), $clients[0]->getSlug()]));
			exit;
		}
		else
		{
			// multiple clients
			//   show overview

			require('view/allconferences.php');
			exit;
		}
	}
	else if(!Conferences::exists($mandator))
	{
		// old url OR wrong client OR
		// -> error
		require('view/404.php');
		exit;
	}
	else {
		// fallthrough through to the main mandator-based routes
	}
}
catch(Exception $e)
{
	ob_clean();
	try {
		require('view/500.php');
		exit;
	}
	catch(Exception $e) {
		header("HTTP/1.1 500 Internal Server Error");
		header("Content-Type: text/plain");
		print_r($e);
		exit;
	}
}


// PER-CONFERENCE CODE
ob_start();
try {
	$conference = Conferences::getConference($mandator);

	if($route == 'config.json')
	{
		require('view/config-json.php');
		exit();
	}

	// update template information
	$tpl->set(array(
		'baseurl' => forceslash(baseurl()),
		'route' => $route,
		'canonicalurl' => joinpath([baseurl(), $mandator, $route]),
		'conference_assets' => forceslash($mandator),

		'conference' => $conference,
		'feedback' => $conference->getFeedback(),
		'schedule' => $conference->getSchedule(),
		'subtitles' => $conference->getSubtitles(),
	));

	// ALWAYS AVAILABLE ROUTES
	if($route == 'feedback/read')
	{
		require('view/feedback-read.php');
	}

	else if($route == 'gen/main.css')
	{
		if(Conferences::hasCustomStyles($mandator))
		{
			handle_lesscss_request(
				Conferences::getCustomStyles($mandator),
				'../../'.Conferences::getCustomStylesDir($mandator)
			);
		}
		else {
			handle_lesscss_request('assets/css/main.less', '../../assets/css/');
		}
	}

	else if($route == 'multiview')
	{
		require('view/multiview.php');
	}

	else if($route == 'schedule')
	{
		require('view/schedule.php');
	}

	else if($route == 'multiview/audio')
	{
		$_GET['selection'] = 'audio';
		require('view/multiview.php');
	}

	else if($route == 'about')
	{
		require('view/about.php');
	}

	// HAS-NOT-BEGUN VIEW
	else if(!$conference->hasBegun())
	{
		require('view/not-started.php');
	}

	// ROUTES AVAILABLE AFTER BUT NOT BEFORE THE CONFERENCE
	else if(preg_match('@^relive/([0-9a-f-]+)$@', $route, $m))
	{
		$_GET = array(
			'id' => $m[1],
		);
		require('view/relive-player.php');
	}

	// ROUTES AVAILABLE AFTER BUT NOT BEFORE THE CONFERENCE
	else if(preg_match('@^relive/([0-9]+)/cut$@', $route, $m))
	{
		$_GET = array(
			'id' => $m[1],
		);
		require('view/relive-player-netcut.php');
	}

	else if($route == 'relive')
	{
		require('view/relive.php');
	}


	// HAS-ENDED VIEW
	else if($conference->hasEnded())
	{
		require('view/closed.php');
	}

	// ROUTES AVAILABLE ONLY DURING THE CONFERENCE
	else if($route == '')
	{
		require('view/overview.php');
	}

	else if($route == 'feedback')
	{
		require('view/feedback.php');
	}

	else if(preg_match('@^([^/]+)$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => '',
			'language' => 'native',
		);
		require('view/room.php');
	}

	else if(preg_match('@^([^/]+)/i18n/([^/]+)$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => '',
			'language' => $m[2],
		);
		require('view/room.php');
	}

	else if(preg_match('@^([^/]+)/(hd|sd|audio|slides|video|hls|dash)$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => 'native',
		);
		require('view/room.php');
	}

	else if(preg_match('@^([^/]+)/(hd|sd|audio|slides|video|hls|dash)/i18n/([^/]+)$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => $m[3],
		);
		require('view/room.php');
	}

	else if(preg_match('@^embed/([^/]+)/(hd|sd|audio|hls|slides|dash)/(native|stereo|[^/]+)(/no-autoplay)?$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => $m[3],
			'autoplay' => !isset($m[4]),
		);
		require('view/embed.php');
	}

	// UNKNOWN ROUTE
	else
	{
		throw new NotFoundException();
	}

}
catch(NotFoundException $e)
{
	ob_clean();
	require('view/404.php');
}
catch(Exception $e)
{
	ob_clean();
	require('view/500.php');
	error_log("Caught: $e");
}
