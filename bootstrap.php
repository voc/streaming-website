<?php

if(!ini_get('short_open_tag'))
	die("`short_open_tag = On` is required\n");

chdir(__DIR__);

require_once('config.php');
require_once('lib/helper.php');
require_once('lib/less.php/Less.php');
require_once('vendor/autoload.php');
