<?php

require_once('config.php');
require_once('lib/PhpTemplate.php');
require_once('lib/helper.php');

$route = @$_GET['route'];
$route = rtrim($route, '/');
$GLOBALS['ROUTE'] = $route;


$GLOBALS['tpl'] = new PhpTemplate('template/page.phtml');
$GLOBALS['tpl']->set(array(
	'baseurl' => baseurl(),
	'assemblies' => './template/assemblies/',
));


if($route == '')
{
	include('view/overview.php');
}

else if(preg_match('@^about$@', $route, $m))
{
	include('view/about.php');
}

else if(preg_match('@^program.json$@', $route, $m))
{
	if(!has('SCHEDULE'))
		return include('view/404.php');

	include('view/program-json.php');
}

else if(preg_match('@^feedback$@', $route, $m))
{
	if(!has('FEEDBACK'))
		return include('view/404.php');

	include('view/feedback.php');
}

else if(preg_match('@^feedback/read$@', $route, $m))
{
	if(!has('FEEDBACK'))
		return include('view/404.php');

	include('view/feedback-read.php');
}

else if(preg_match('@^relive/([0-9]+)$@', $route, $m))
{
	if(!has('OVERVIEW.RELIVE_JSON'))
		return include('view/404.php');

	$_GET = array(
		'id' => $m[1],
	);
	include('view/relive-player.php');
}

else if(preg_match('@^relive$@', $route, $m))
{
	if(!has('OVERVIEW.RELIVE_JSON'))
		return include('view/404.php');

	include('view/relive.php');
}

else if(preg_match('@^([^/]+)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => '',
		'language' => 'native',
	);
	include('view/room.php');
}

else if(preg_match('@^([^/]+)/translated$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => '',
		'language' => 'translated',
	);
	include('view/room.php');
}

else if(preg_match('@^([^/]+)/(sd|audio|slides)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => $m[2],
		'language' => 'native',
	);
	include('view/room.php');
}

else if(preg_match('@^([^/]+)/(sd|audio|slides)/translated$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => $m[2],
		'language' => 'translated',
	);
	include('view/room.php');
}

else
{
	include('view/404.php');
}
