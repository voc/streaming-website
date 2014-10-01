<?php

require_once('lib/PhpTemplate.php');
require_once('lib/helper.php');
require_once('config.php');

$room = $_GET['room'];

$tpl = new PhpTemplate('template/page.phtml');
echo $tpl->render(array(
	'page' => 'rooms',
	'baseurl' => baseurl(),
	'title' => 'Stream-Formats',
	'subtitle' => ucfirst($room),

	'room' => $room,
	'formats' => array(
		'hd' => 'FullHD',
		'hq' => 'High Quality',
		'lq' => 'Low Quality',
		'audio' => 'Audio-Only',
		'slides' => 'Slide-Images + Audio',
	),
));
