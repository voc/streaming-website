<?php

use C3VOC\StreamingWebsite\View\AllConferences;
use C3VOC\StreamingWebsite\View\Overview;

require_once('bootstrap.php');

$app = new Silex\Application();
$app->get('/', AllConferences::class . '::action');
$app->get('/{conference}', Overview::class . '::action');

$app['debug'] = true;

$app->run();
