<?php

namespace C3VOC\StreamingWebsite\Lib;

set_error_handler(function($errno, $errstr, $errfile, $errline ) {
	if (error_reporting() == 0)
		return;

	throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});

class NotFoundException extends \Exception {}
class ScheduleException extends \Exception {}
class ConfigException extends \Exception {}
