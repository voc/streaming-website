<?php

header("HTTP/1.1 500 Internal Server Error");

if ($OUTPUT_JSON) {
	header('Content-Type: application/json');
	echo json_encode([
		'status' => 500,
		'error' => '500 Internal Server Error',
		'message' => $e->getMessage(),
		// 'exception' => $e->getTraceAsString(),
	]);
} 
else 
{
	echo $tpl->render(array(
		'page' => '500',
		'title' => '500 Internal Server Error',
		'e' => $e,
		'msg' => $e->getMessage(),
	));
}
