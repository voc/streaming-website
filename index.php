<?php

use C3VOC\StreamingWebsite\Lib\PhpTemplate;
use C3VOC\StreamingWebsite\Lib\Router;

use C3VOC\StreamingWebsite\Model\GenericConference;
use C3VOC\StreamingWebsite\Model\Conferences;

use C3VOC\StreamingWebsite\Command;
use C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite;

require_once('bootstrap.php');

ob_start();
if(isset($argv) && isset($argv[1]))
{
	$cmd = null;
	switch($argv[1])
	{
		case 'download':
			$cmd = new Command\Download;
	}

	if(is_null($cmd))
	{
		stderr("Unknown Command: %s", $argv[1]);
		exit(1);
	}
	else {
		exit( $cmd->run($argv) );
	}
}


try {
	if(isset($_GET['htaccess']))
	{
		$route = @$_GET['route'];
	}
	elseif(isset($_SERVER["REQUEST_URI"]))
	{
		$route = ltrim(@$_SERVER["REQUEST_URI"], '/');

		// serve static
		if($route != '' && file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$route))
		{
			return false;
		}

	}
	else $route = '';


	$router = new Router($route);
	$view = $router->createView();
	$view
		->outputHeaders()
		->outputBody();
}
catch(NotFoundException $e)
{
	ob_clean();
	require('view/404.php');
}
catch(Exception $e)
{
	ob_clean();
	require('view/500.php');
}
