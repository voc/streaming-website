<?php

$upcoming = new Upcoming();

echo $tpl->render(array(
	'page' => 'closed',
	'title' => 'See you soon … somewhere else!',

	'upcoming' => $upcoming->getNextEvent(),
));
