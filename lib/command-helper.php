<?php

function stderr($str) {
	$args = func_get_args();
	$args[0] = $args[0]."\n";
	array_unshift($args, STDERR);
	call_user_func_array('fprintf', $args);
}

function stdout($str) {
	$args = func_get_args();
	$args[0] = $args[0]."\n";
	array_unshift($args, STDOUT);
	call_user_func_array('fprintf', $args);
}
