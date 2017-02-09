<?php

namespace C3VOC\StreamingWebsite\View;

use C3VOC\StreamingWebsite\Lib\Router;

class GlobalCssView extends View
{
	public  function render()
	{
		$this->setHeader('Content-Type', 'text/css');
		return compile_lesscss('assets/css/main.less', '../assets/css/');
	}
}
