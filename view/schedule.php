<?php

echo $tpl->render(array(
	'page' => 'schedule',
	'title' => 'Schedule-Übersicht',

	'schedule' => new Schedule(),
));
