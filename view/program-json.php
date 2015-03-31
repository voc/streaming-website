<?php

$schedule = new Schedule();
if(!$schedule->isEnabled())
	throw new NotFoundException('Schedule is disabled');

header('Content-Type: application/json');
echo json_encode(program());
