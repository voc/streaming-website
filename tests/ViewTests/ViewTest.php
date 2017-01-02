<?php

trait ViewTest
{
	private function executeView($name)
	{
		ob_start();
		require(joinpath([
			'view',
			$name
		]));
		return ob_get_clean();
	}
}
