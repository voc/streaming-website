<?php

header('Content-Type: application/json');

$basetime = time();
$struct = [];
foreach (Conferences::getActiveConferences() as $conference)
{
	$now = $conference->getSchedule()->getScheduleDisplayTime($basetime);
	$overview = $conference->getOverview();

	$isCurrentlyStreaming = false;

	// iterate through all rooms and only activate flag if there is something other than a daychange event
	foreach($conference->getRooms() as $room) {
		$currentTalk = $room->getCurrentTalk($now);

		if ($currentTalk) {
			// if current event is a daychange ignore room, but only if the next talk does not start in 30 minutes
			if ( !(isset($currentTalk['special']) && $currentTalk['special'] == 'daychange' && $currentTalk['end'] - $basetime > 30*60 )) {
				$isCurrentlyStreaming = true;
				break;
			}
		}
	}

	$groupstruct = array();
	foreach($overview->getGroups() as $group => $rooms)
	{
		$roomstruct = array();
		foreach($rooms as $room)
		{
			$streams = array();
			foreach($room->getStreams() as $stream)
			{
				$key = $stream->getSelection().'-'.$stream->getLanguage();

				$urls = array();
				switch($stream->getPlayerType())
				{
					case 'video':
						foreach ($stream->getVideoProtos() as $proto => $display)
						{
							$urls[$proto] = array(
								'display' => $display,
								'tech' => $stream->getVideoTech($proto),
								'url' => $stream->getVideoUrl($proto),
							);
						}
						break;

					case 'slides':
						foreach ($stream->getSlidesProtos() as $proto => $display)
						{
							$urls[$proto] = array(
								'display' => $display,
								'tech' => $stream->getSlidesTech($proto),
								'url' => $stream->getSlidesUrl($proto),
							);
						}
						break;

					case 'audio':
						foreach ($stream->getAudioProtos() as $proto => $display)
						{
							$urls[$proto] = array(
								'display' => $display,
								'tech' => $stream->getAudioTech($proto),
								'url' => $stream->getAudioUrl($proto),
							);
						}
						break;

					case 'music':
						foreach ($stream->getMusicProtos() as $proto => $display)
						{
							$urls[$proto] = array(
								'display' => $display,
								'tech' => $stream->getMusicTech($proto),
								'url' => $stream->getMusicUrl($proto),
							);
						}
						break;
									
					case 'dash':
						if(!$room->h264Only()):
							$urls['dash'] = array(
								'display' => 'DASH, baby',
								'tech' => $room->getDashTech(),
								'url' => $room->getDashManifestUrl(),
							);
							break;
						endif;
				}

				if(!$room->h264Only()):
					$streams[] = array(
						'slug' => $key,
						'display' => $stream->getDisplay(),
						'type' => $stream->getPlayerType(),
						'isTranslated' => $stream->isTranslated(),
						'videoSize' => $stream->getVideoSize(),
						'urls' => (object)$urls,
					);
				endif;
			}

			$roomstruct[] = array(
				'slug' => $room->getSlug(),
				'schedulename' => $room->getScheduleName(),
				'thumb' => $room->getThumb(),
				'poster' => $room->getPoster(),
				'link' => forceslash(baseurl()).$room->getLink(),
				'display' => $room->getDisplay(),
				'stream' => $room->getStream(),
				'talks' => [
					'current' => $room->getCurrentTalk($now),
					'next' => $room->getNextTalk($now),
				],
				'streams' => $streams,
			);
		}

		$groupstruct[] = array(
			'group' => $group,
			'rooms' => $roomstruct,
		);
	}
	$struct[] = array(
		'conference' => $conference->getTitle(),
		'slug' => $conference->getSlug(),
		'author' => $conference->getAuthor(),
		'description' => $conference->getDescription(),
		'keywords' => $conference->getKeywords(),
		'schedule' => $conference->getSchedule()->getScheduleUrl(),
		'startsAt' => $conference->startsAt() ? $conference->startsAt()->format(DateTime::ISO8601) : null,
		'endsAt' => $conference->endsAt() ? $conference->endsAt()->format(DateTime::ISO8601) : null,
		'isCurrentlyStreaming' => $isCurrentlyStreaming,
		'groups' => $groupstruct,
	);
}

echo json_encode($struct, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
