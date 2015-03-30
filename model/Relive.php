<?php

class Relive extends ModelBase
{
	function relive_talks()
	{
		$talks = @file_get_contents(get('OVERVIEW.RELIVE_JSON'));
		$talks = utf8_decode($talks);
		$talks = (array)json_decode($talks, true);

		usort($talks, function($a, $b) {
			$sort = array('live', 'recorded', 'released');
			return array_search($a['status'], $sort) > array_search($b['status'], $sort);
		});

		$talks_by_id = array();
		foreach ($talks as $value)
		{
			$talks_by_id[$value['id']] = $value;
		}

		return $talks_by_id;
	}
}
