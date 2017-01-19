<?php

namespace C3VOC\StreamingWebsite\Lib;

class Autoloader
{
	public function register() {
		spl_autoload_register([$this, 'autoload']);
	}

	public function registerMapping($prefix, $folder) {
		if(!endswith('\\', $prefix))
			$prefix .= '\\';
		$this->mappings[$prefix] = $folder;
	}

	public function autoload($class) {
		foreach($this->mappings as $prefix => $directory) {
			if(startswith($prefix, $class)) {
				$path = joinpath([
					$directory,
					suffix($prefix, $class) . '.php'
				]);
				/** @noinspection PhpIncludeInspection */
				require_once($path);
			}
		}
	}

}
