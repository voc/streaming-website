<?php

echo $tpl->render(array(
	'page' => 'multiview',
	'title' => 'Stream-Übersicht',

	'rooms' => $conference->getRooms(),
	'selection' => @$_GET['selection'],
));
