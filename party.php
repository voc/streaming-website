<?php

require_once('lib/PhpTemplate.php');
require_once('lib/helper.php');
require_once('config.php');

$room = $_GET['room'];

$tpl = new PhpTemplate('template/page.phtml');
echo $tpl->render(array(
	'page' => 'party',

	'baseurl' => baseurl(),
	'title' => $GLOBALS['CONFIG']['ROOMS'][$room],

	'rooms' => $GLOBALS['CONFIG']['ROOMS'],

	'room' => $room,
	'roomname' => $GLOBALS['CONFIG']['ROOMS'][$room],
));
