<?php

require_once('lib/PhpTemplate.php');
require_once('lib/helper.php');
require_once('config.php');

$tpl = new PhpTemplate('template/page.phtml');
$tpl->set(array(
	'baseurl' => baseurl(),
	'assemblies' => './template/assemblies/',
));
