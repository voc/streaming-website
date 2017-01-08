<?php

use C3VOC\StreamingWebsite\Model\Upcoming;
use C3VOC\StreamingWebsite\Model\Conferences;

$upcoming = new Upcoming();
$events = $upcoming->getNextEvents();

echo $tpl->render(array(
	'page' => 'allclosed',
	'title' => 'See you soon … somewhere else!',

	'next' => @$events[0],
	'events' => $events,
	'last' => Conferences::getLastConference(),
));
