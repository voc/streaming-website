<?php

namespace C3VOC\StreamingWebsite\Command;

abstract class AbstractCommand
{
	protected function stderr($str) {
		$args = func_get_args();
		$args[0] = $args[0]."\n";
		array_unshift($args, STDERR);
		call_user_func_array('fprintf', $args);
	}

	protected function stdout($str) {
		$args = func_get_args();
		$args[0] = $args[0]."\n";
		array_unshift($args, STDOUT);
		call_user_func_array('fprintf', $args);
	}

	abstract public function run($argv);
}
