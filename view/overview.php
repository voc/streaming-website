<?php

$schedule = $conference->getSchedule();

$talksPerRoom = $schedule->getSchedule();
$now = time() + $schedule->getSimulationOffset();

$upcomingTalksPerRoom = array_map(function($talks) use($now) {
	return [
		'current' => array_filter_last($talks, function($talk) use ($now) {
			return $talk['start'] < $now && $talk['end'] > $now;
		}),
		'next' => array_filter_first($talks, function($talk) use ($now) {
			return !isset($talk['special']) && $talk['start'] > $now;
		}),
	];
}, $talksPerRoom);

echo $tpl->render(array(
	'page' => 'overview',
	'title' => 'Live-Streams',

	'overview' => $conference->getOverview(),

	'upcomingTalksPerRoom' => $upcomingTalksPerRoom,
));
