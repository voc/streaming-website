<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;
use C3VOC\StreamingWebsite\Lib\NotFoundException;

class NotFoundView extends View
{
	private $exception;

	public function __construct(Router $router, NotFoundException $e)
	{
		parent::__construct($router);
		$this->exception = $e;
	}

	public function render()
	{
		$tpl = $this->createPageTemplate();
		return $tpl->render([
			'page' => '404',
			'title' => '404 Not Found',

			'e' => $this->exception,
			'msg' => $this->exception->getMessage(),
		]);
	}
}
