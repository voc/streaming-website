<?php

class Schedule extends ModelBase
{
	public function getSimulationOffset() {
		return $this->get('SCHEDULE.SIMULATE_OFFSET', 0);
	}
}
