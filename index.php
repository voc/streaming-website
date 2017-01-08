<?php

use C3VOC\StreamingWebsite\Lib\PhpTemplate;
use C3VOC\StreamingWebsite\Model\GenericConference;
use C3VOC\StreamingWebsite\Model\Conferences;

use C3VOC\StreamingWebsite\Command;
use C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite;

require_once('bootstrap.php');

ob_start();
if(isset($argv) && isset($argv[1]))
{
	$cmd = null;
	switch($argv[1])
	{
		case 'download':
			$cmd = new Command\Download;
	}

	if(is_null($cmd))
	{
		stderr("Unknown Command: %s", $argv[1]);
		exit(1);
	}
	else {
		exit( $cmd->run($argv) );
	}
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
	$GLOBALS['ROUTE'] = $route;

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
		$view = new View\StreamsJsonV1();
		$view
			->outputHeaders()
			->outputBody();

		exit;
	}

	else if($route == 'streams/v2.json')
	{
		$view = new View\StreamsJsonV2();
		$view
			->outputHeaders()
			->outputBody();

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
	else if(preg_match('@^relive/([0-9]+)$@', $route, $m))
	{
		$_GET = array(
			'id' => $m[1],
		);
		require('view/relive-player.php');
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

	else if(preg_match('@^([^/]+)/translated$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => '',
			'language' => 'translated',
		);
		require('view/room.php');
	}

	else if(preg_match('@^([^/]+)/(sd|audio|slides|dash)$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => 'native',
		);
		require('view/room.php');
	}

	else if(preg_match('@^([^/]+)/(sd|audio|slides|dash)/translated$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => 'translated',
		);
		require('view/room.php');
	}

	else if(preg_match('@^embed/([^/]+)/(hd|sd|audio|slides)/(native|translated|stereo)(/no-autoplay)?$@', $route, $m))
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
}
