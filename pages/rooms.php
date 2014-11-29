<?php

require_once('lib/bootstrap.php');

echo $tpl->render(array(
	'page' => 'rooms',
	'title' => 'Overview',

	'rooms' => $GLOBALS['CONFIG']['ROOMS'],
));
