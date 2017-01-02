<?php
namespace C3VOC\StreamingWebsite\Tests;

use PHPUnit\Framework\TestCase;
require_once('ViewTest.php');
require_once('Factory.php');

class RoomTest extends TestCase
{
	use ViewTest;

	public function testOverviewDoesReturnContent()
	{
		$conference = Factory::createConference();

		$this->setConference($conference);
		$this->setGetParams([
			'room' => 'hall1',
			'selection' => '',
			'language' => 'native',
		]);
		$html = $this->executeView('room.php');

		$this->assertInternalType('string', $html);
		$this->assertContains('Saal 1', $html);
		$this->assertNotContains('Saal 2', $html);
	}
}
