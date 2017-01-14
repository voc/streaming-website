<?php

if(!ini_get('short_open_tag'))
	die("`short_open_tag = On` is required\n");

$GLOBALS['BASEDIR'] = dirname(__FILE__);
chdir($GLOBALS['BASEDIR']);

require_once('config.php');
require_once('lib/helper.php');

require_once('lib/PhpTemplate.php');
require_once('lib/Exceptions.php');
require_once('lib/Router.php');
require_once('lib/less.php/Less.php');

require_once('model/ModelBase.php');
require_once('model/Conferences.php');
require_once('model/Conference.php');
require_once('model/GenericConference.php');
require_once('model/Feedback.php');
require_once('model/Schedule.php');
require_once('model/Subtitles.php');
require_once('model/Overview.php');
require_once('model/Room.php');
require_once('model/RoomTab.php');
require_once('model/RoomSelection.php');
require_once('model/Stream.php');
require_once('model/Relive.php');
require_once('model/Upcoming.php');

require_once('command/AbstractCommand.php');
require_once('command/Download.php');

require_once('view/View.php');
require_once('view/ConferenceView.php');
require_once('view/NotFoundView.php');
require_once('view/StreamsJsonV1.php');
require_once('view/StreamsJsonV2.php');
