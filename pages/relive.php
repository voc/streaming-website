<?php

require_once('lib/bootstrap.php');

$talks = file_get_contents('http://vod.c3voc.de/relive/index.json');
$talks = utf8_decode($talks);
$talks = json_decode($talks, true);

usort($talks, function($a, $b) {
	$sort = array('live', 'recorded', 'released');
	return array_search($a['status'], $sort) > array_search($b['status'], $sort);
});

echo $tpl->render(array(
	'page' => 'relive',
	'title' => 'Relive!',
	'talks' => $talks,

	'relive' => true,
));
