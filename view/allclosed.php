<?php

$events = Upcoming::getNextEvents();

echo $tpl->render(array(
	'page' => 'allclosed',
	'title' => 'See you soon … somewhere else!',

	'next' => isset($events[0]) ? $events[0] : null,
	'events' => $events,
	'last' => Conferences::getLastConference(),
));
