<?php

echo $tpl->render(array(
	'page' => 'overview',
	'title' => 'Live-Streams',

	'overview' => $conference->getOverview(),
));
