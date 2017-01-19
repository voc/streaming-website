<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;

class GlobalCssView extends View
{
	public function __construct(Router $router)
	{
		parent::__construct($router);
		$this->setHeader('Content-Type', 'text/css');
	}

	public  function render()
	{
		return compile_lesscss('assets/css/main.less', '../assets/css/');
	}
}