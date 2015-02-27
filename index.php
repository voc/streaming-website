<?php

$route = @$_GET['route'];
$route = rtrim($route, '/');



if($route == '')
{
	include('pages/overview.php');
}

else if(preg_match('@^([^/]+)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => 'hd',
		'language' => 'native',
	);
	include('pages/room.php');
}

else if(preg_match('@^([^/]+)/translated$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => 'hd',
		'language' => 'translated',
	);
	include('pages/room.php');
}

else if(preg_match('@^([^/]+)/(sd|audio|slides)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => $m[2],
		'language' => 'native',
	);
	include('pages/room.php');
}

else if(preg_match('@^([^/]+)/(sd|audio|slides)/translated$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'selection' => $m[2],
		'language' => 'translated',
	);
	include('pages/room.php');
}

else if(preg_match('@^about$@', $route, $m))
{
	include('pages/about.php');
}

else if(preg_match('@^program.json$@', $route, $m))
{
	include('pages/program-json.php');
}

else if(preg_match('@^feedback$@', $route, $m))
{
	include('pages/feedback.php');
}

else if(preg_match('@^feedback/read$@', $route, $m))
{
	include('pages/feedback-read.php');
}

else if(preg_match('@^relive/([0-9]+)$@', $route, $m))
{
	$_GET = array(
		'id' => $m[1],
	);
	include('pages/relive-player.php');
}

else if(preg_match('@^relive$@', $route, $m))
{
	include('pages/relive.php');
}

else
{
	include('pages/404.php');
}
