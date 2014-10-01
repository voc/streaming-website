<?php

require_once('lib/PhpTemplate.php');
require_once('lib/helper.php');
require_once('config.php');

$tpl = new PhpTemplate('template/page.phtml');
echo $tpl->render(array(
	'page' => 'rooms',
	'baseurl' => baseurl(),
	'title' => 'Rooms',

	'rooms' => array('saal1','saal2','saalg','saalz','launge','sendezentrum'),
));
