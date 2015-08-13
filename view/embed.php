<?php

$room = new Room($_GET['room']);
if(!$room->hasEmbed())
	throw new NotFoundException('Embedding is not enabled in this room');

$stream = $room->selectStream(
	$_GET['selection'], $_GET['language']);

echo $tpl->render(array(
	'page' => 'embed',
	'naked' => true, // no header/footer

	'title' => $stream->getDisplay(),
	'room' => $room,
	'stream' => $stream,

	'autoplay' => @$_GET['autoplay'],
));
