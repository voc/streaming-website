<?php
namespace C3VOC\StreamingWebsite\Tests;

use PHPUnit\Framework\TestCase;
require_once('ViewTest.php');
require_once('Factory.php');

class OverviewTest extends TestCase
{
	use ViewTest;

	public function testOverviewDoesReturnContent()
	{
		$conference = Factory::createConference();

		$this->setConference($conference);
		$html = $this->executeView('overview.php');

		$this->assertInternalType('string', $html);
		$this->assertContains('Saal 1', $html);
		$this->assertContains('Saal 2', $html);
		$this->assertContains('<body class="overview">', $html);
	}
}
