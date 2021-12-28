<?php

$relive = $conference->getRelive();
if(!$relive->isEnabled())
	throw new NotFoundException('Internal Relive is disabled');

$talk = $relive->getTalk($_GET['id']);

if($talk['status'] == 'released' && empty($_GET['redirect'])) {
	header("HTTP/1.1 301 Moved Permanently"); 
	header('Location: ' . $talk['release_url']);
	return;
}

echo $tpl->render(array(
	'page' => 'relive-player',
	'title' => 'Relive: ' . $talk['title'],
	'talk' => $talk,

	'width' => 1920,
	'height' => 1080,
));
