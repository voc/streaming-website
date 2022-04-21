<?php

$events = Upcoming::getNextEvents();

echo $tpl->render(array(
	'page' => 'closed',
	'title' => 'See you soon … somewhere else!',

	'next' => @$events[0],
	'events' => $events,
));
