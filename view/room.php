<?php

$room = $conference->getRoom($_GET['room']);
$selection = $_GET['selection'];
$language = $_GET['language'];

if (! $room->isValidLanguage($language)) {
  throw new NotFoundException('Language not found');
}

$stream = $room->selectStream($selection, $language);

echo $tpl->render(array(
	'page' => 'room',

	'title' => $stream->getDisplay(),
	'room' => $room,
	'stream' => $stream,

	'schedule' => $conference->getSchedule(),
));
