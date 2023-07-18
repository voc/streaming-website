<?php

echo $tpl->render(array(
	'page' => 'multiview',
	'title' => 'Stream-Übersicht',

	'rooms' => $conference->getRooms(),
	'selection' => isset($_GET['selection']) ? $_GET['selection'] : "",
));
