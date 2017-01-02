<?php
namespace C3VOC\StreamingWebsite\Tests;

class Factory {

	public static function createConference() {
		return new \Conference([
			'TITLE' => 'LalaCon',
			'OVERVIEW' => [
				'GROUPS' => [
					'Live' => [
						'hall1',
						'hall2',
					],
				],
			],
			'ROOMS' => [
				'hall1' => [
					'DISPLAY' => 'Saal 1',
					'STREAM' => 's1',
					'HD_VIDEO' => true,
				],
				'hall2' => [
					'DISPLAY' => 'Saal 2',
					'STREAM' => 's2',
					'HD_VIDEO' => true,
				],
			],
		], 'lala');
	}
}
