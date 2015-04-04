<?php

require_once('config.php');

require_once('lib/PhpTemplate.php');
require_once('lib/Exceptions.php');
require_once('lib/helper.php');

require_once('model/ModelBase.php');
require_once('model/Conference.php');
require_once('model/Feedback.php');
require_once('model/Schedule.php');
require_once('model/Overview.php');
require_once('model/Room.php');
require_once('model/RoomTab.php');
require_once('model/RoomSelection.php');
require_once('model/Stream.php');
require_once('model/Relive.php');
require_once('model/Upcoming.php');

$route = @$_GET['route'];
$route = rtrim($route, '/');

$conference = new Conference();

$tpl = new PhpTemplate('template/page.phtml');
$tpl->set(array(
	'baseurl' => baseurl(),
	'route' => $route,
	'assemblies' => './template/assemblies/',

	'conference' => $conference,
	'feedback' => new Feedback(),
	'schedule' => new Schedule(),
));


ob_start();
try {


	if($route == 'feedback/read')
	{
		require('view/feedback-read.php');
	}

	else if($conference->isClosed())
	{
		require('view/closed.php');
	}

	else if($route == '')
	{
		require('view/overview.php');
	}

	else if($route == 'about')
	{
		require('view/about.php');
	}

	else if($route == 'schedule.json')
	{
		require('view/schedule-json.php');
	}

	else if($route == 'multiview')
	{
		require('view/multiview.php');
	}

	else if($route == 'feedback')
	{
		require('view/feedback.php');
	}

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

	else if(preg_match('@^([^/]+)/(sd|audio|slides)$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => 'native',
		);
		require('view/room.php');
	}

	else if(preg_match('@^([^/]+)/(sd|audio|slides)/translated$@', $route, $m))
	{
		$_GET = array(
			'room' => $m[1],
			'selection' => $m[2],
			'language' => 'translated',
		);
		require('view/room.php');
	}

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
