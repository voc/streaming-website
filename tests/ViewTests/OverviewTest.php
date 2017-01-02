<?php
use PHPUnit\Framework\TestCase;
require_once('ViewTest.php');

class OverviewTest extends TestCase
{
	use ViewTest;

	public function testOverviewDoesReturnContent()
	{
		$html = $this->executeView('overview.php');
		$this->assertString($html);
	}
}
