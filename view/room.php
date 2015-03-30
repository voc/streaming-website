<?php

$room = new Room($_GET['room']);
$stream = $room->selectStream(
	$_GET['selection'], $_GET['language']);

echo $tpl->render(array(
	'page' => 'room',

	'title' => $stream->getDisplay(),
	'room' => $room,
	'stream' => $stream,

	'schedule' => new Schedule(),
));
