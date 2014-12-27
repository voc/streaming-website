<?php

require_once('lib/bootstrap.php');

$talks = file_get_contents('http://vod.c3voc.de/relive/index.json');
$talks = json_decode($talks, true);

$talkhit = null;
foreach($talks as $talk) {
	if($talk['id'] == $_GET['id'])
		$talkhit = $talk;
}

if(!$talkhit) return;

echo $tpl->render(array(
	'page' => 'relive-player',
	'title' => 'Relive!',
	'talk' => $talkhit,

	'width' => 1024,
	'height' => 576,
	'relive' => true,
));
