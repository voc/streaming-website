<?php

$schedule = $conference->getSchedule();

$now = time() + $schedule->getSimulationOffset();
$upcomingTalksPerRoom = [];
foreach ($conference->getRooms() as $room) {
	$upcomingTalksPerRoom[$room->getSlug()] = [
		'current' => $room->getCurrentTalk($now),
		'next' => $room->getNextTalk($now),
	];
};

echo $tpl->render(array(
	'page' => 'overview',
	'title' => 'Live-Streams',

	'overview' => $conference->getOverview(),

	'upcomingTalksPerRoom' => $upcomingTalksPerRoom,
));
