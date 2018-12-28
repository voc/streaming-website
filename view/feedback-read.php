<?php

$feedback = $conference->getFeedback();
if(!$feedback->isLoggedIn())
{
	$feedback->requestLogin();
	exit;
}

$from = isset($_POST['from']) ? strtotime($_POST['from']) : time();
$to   = isset($_POST['to'])   ? strtotime($_POST['to'])   : time() + 24*60*60;
$cols = isset($_POST['col'])  ? $_POST['col']          : array('reported', 'stream', 'os', 'player', 'issues', 'issuetext');

$allcols = array('reported', 'datetime', 'net', 'os', 'stream', 'player', 'ipproto_v4', 'ipproto_v6', 'provider', 'issues', 'issuetext');

echo $tpl->render(array(
	'page' => 'feedback-read',
	'title' => 'Read Feedback',

	'from' => $from,
	'to' => $to,
	'responses' => $feedback->read($from, $to),

	'columns' => array_intersect($allcols, $cols),
	'allcolumns' => $allcols,
	'hostname' => @$_SERVER['SERVER_NAME'],
));
