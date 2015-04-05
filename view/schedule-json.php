<?php

$schedule = new Schedule();
if(!$schedule->isEnabled())
	throw new NotFoundException('Schedule is disabled');

header('Content-Type: application/json');

if($conference->isClosed())
	echo '{}';

else
	echo json_encode($schedule->getSchedule(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
