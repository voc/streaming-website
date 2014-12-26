<?php

$route = @$_GET['route'];
$route = rtrim($route, '/');



if($route == '')
{
	include('pages/rooms.php');
}

else if(preg_match('@^(saal1|saal2|saalg|saal6|sendezentrum)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'format' => 'sd',
		'language' => 'native',
	);
	include('pages/room.php');
}

else if(preg_match('@^(saal1|saal2|saalg|saal6)/translated$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'format' => 'sd',
		'language' => 'translated',
	);
	include('pages/room.php');
}

else if(preg_match('@^(saal1|saal2|saalg|saal6|sendezentrum)/(hd|audio|slides)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'format' => $m[2],
		'language' => 'native',
	);
	include('pages/room.php');
}

else if(preg_match('@^(saal1|saal2|saalg|saal6)/(hd|audio|slides)/translated$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'format' => $m[2],
		'language' => 'translated',
	);
	include('pages/room.php');
}

else if(preg_match('@^(lounge|ambient)$@', $route, $m))
{
	$_GET = array(
		'room' => $m[1],
		'format' => 'audio',
	);
	include('pages/party.php');
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

else if(preg_match('@^relive$@', $route, $m))
{
	include('pages/relive.php');
}

else
{
	include('pages/404.php');
}
