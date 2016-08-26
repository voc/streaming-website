<?php

$relive = new Relive();
if(!$relive->isEnabled())
	throw new NotFoundException('Internal Relive is disabled');

$talk = $relive->getTalk(intval($_GET['id']));

echo $tpl->render(array(
	'page' => 'relive-player',
	'title' => 'Relive: ' . $talk['title'],
	'talk' => $talk,

	'width' => 1024,
	'height' => 576,
));
