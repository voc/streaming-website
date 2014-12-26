<?php

require_once('lib/bootstrap.php');

echo $tpl->render(array(
	'page' => 'relive',
	'title' => 'Relive!',
	'extraScripts' => array(
		'assets/js/lustiges-relive-script.js',
	),
));
