<?php

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
	if (ini_get('error_reporting') == 0)
		return;

	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

class NotFoundException extends Exception {}
class ScheduleException extends Exception {}
