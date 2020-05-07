<?php

$room = $conference->getRoom($_GET['room']);

if(!$room->hasEmbed())
	throw new NotFoundException('Embedding is not enabled in this room');

$selection = $_GET['selection'];
$language = $_GET['language'];

if ($language !== 'native') {
	if (! $room->hasTranslation()) {
		throw new NotFoundException('Not translated');
	}

	if (! $room->isValidLanguage($language)) {
		throw new NotFoundException('Language not found');
	}
}

$stream = $room->selectStream($selection, $language);

echo $tpl->render(array(
	'page' => 'embed',
	'naked' => true, // no header/footer

	'title' => $stream->getDisplay(),
	'room' => $room,
	'stream' => $stream,

	'autoplay' => @$_GET['autoplay'],
));
