<?php

echo $tpl->render(array(
	'page' => 'overview',
	'title' => 'Live-Streams',

	'overview' => new Overview(),
));
