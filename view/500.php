<?php

header("HTTP/1.1 500 Internal Server Error");
echo $tpl->render(array(
	'page' => '500',
	'title' => '500 Internal Server Error',

	'e' => $e,
	'msg' => $e->getMessage(),
));
