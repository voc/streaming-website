<?php

if(!ini_get('short_open_tag'))
	die("`short_open_tag = On` is required\n");

$GLOBALS['BASEDIR'] = dirname(__FILE__);
chdir($GLOBALS['BASEDIR']);

require_once('config.php');
require_once('lib/helper.php');
require_once('lib/Exceptions.php');
require_once('lib/less.php/Less.php');
require_once('lib/Autoloader.php');

$autoloader = new C3VOC\StreamingWebsite\Lib\Autoloader();
$autoloader->registerMapping('C3VOC\\StreamingWebsite\\Lib', 'lib');
$autoloader->registerMapping('C3VOC\\StreamingWebsite\\Model', 'model');
$autoloader->registerMapping('C3VOC\\StreamingWebsite\\Command', 'command');
$autoloader->registerMapping('C3VOC\\StreamingWebsite\\View', 'view');
$autoloader->register();
