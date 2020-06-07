<?php

$relive = $conference->getRelive();
$talk = $relive->getTalk(intval($_GET['id']));

echo $tpl->render(array(
	'page' => 'relive-player-netcut',
	'title' => $talk['title'],
	'talk' => $talk,

	'width' => 1920,
	'height' => 1080,
));
