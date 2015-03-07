<?php

$talks_by_id = relive_talks();
$talk = @$talks_by_id[intval($_GET['id'])];

if(!$talk)
	return include('page/404.php');

echo $tpl->render(array(
	'page' => 'relive-player',
	'title' => 'Relive!',
	'talk' => $talk,

	'width' => 1024,
	'height' => 576,
));
