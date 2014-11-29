<?php

require_once('lib/bootstrap.php');

echo $tpl->render(array(
	'page' => '404',
	'title' => '404 Not Found',
));
