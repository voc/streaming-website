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

		$this->setHttpResponse("HTTP/1.1 500 Internal Server Error");
	}

	public function render()
	{
		$tpl = $this->createPageTemplate();
		return $tpl->render([
			'page' => '500',
			'title' => '500 Internal Server Error',

			'e' => $this->exception,
			'msg' => $this->exception->getMessage(),
		]);
	}
}
