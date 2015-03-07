<?php

header("HTTP/1.1 404 Not Found");
echo $tpl->render(array(
	'page' => '404',
	'title' => '404 Not Found',
));
