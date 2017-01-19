<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;

class ErrorView extends View
{
	private $exception;

	public function __construct(Router $router, \Exception $e)
	{
		parent::__construct($router);
		$this->exception = $e;
	}

	public function render()
	{
		return 'ErrorView';
	}
}
