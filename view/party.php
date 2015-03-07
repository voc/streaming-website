<?php

$room = $_GET['room'];
echo $tpl->render(array(
	'page' => 'party',

	'title' => $GLOBALS['CONFIG']['ROOMS'][$room],

	'rooms' => $GLOBALS['CONFIG']['ROOMS'],

	'room' => $room,
	'roomname' => $GLOBALS['CONFIG']['ROOMS'][$room],
));
