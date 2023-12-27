<?php

// Version 1.2

if(!function_exists('h'))
{
	function h($s)
	{
		return htmlspecialchars($s);
	}
}

class PhpTemplate
{
	private $data = array();
	public $file;

	public function __construct($file)
	{
		$this->file = $file;
		$this->data["naked"] = false;
	}

	public function set($___data = array())
	{
		$this->data = array_merge($this->data, $___data);
	}

	public function render($___data = array())
	{
		extract(array_merge($this->data, $___data));
		unset($___data);

		ob_start();
		require($this->file);
		return ob_get_clean();
	}
	
	public function __tostring()
	{
		return $this->render();
	}
}
