<?php

header("HTTP/1.1 404 Not Found");

if ($OUTPUT_JSON) {
	header('Content-Type: application/json');
	echo json_encode([
		'status' => 404,
		'error' => '404 Not Found',
		'message' => $e->getMessage(),
	]);
} 
else {
	echo $tpl->render(array(
		'page' => '404',
		'title' => '404 Not Found',
	));
}