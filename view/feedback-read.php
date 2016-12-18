<?php

$feedback = $conference->getFeedback();
if(!$feedback->isLoggedIn())
{
	$feedback->requestLogin();
	exit;
}

$from = isset($_POST['from']) ? strtotime($_POST['from']) : strtotime('2000-01-01');
$to   = isset($_POST['to'])   ? strtotime($_POST['to'])   : time() + 24*60*60;
$cols = isset($_POST['col'])  ? $_POST['col']          : array('reported', 'issuetext');

$allcols = array('reported', 'datetime', 'net', 'os', 'player', 'stream', 'ipproto_v4', 'ipproto_v6', 'provider', 'issues', 'issuetext');

echo $tpl->render(array(
	'page' => 'feedback-read',
	'title' => 'Read Feedback',

	'from' => $from,
	'to' => $to,
	'responses' => $feedback->read($from, $to),

	'columns' => array_intersect($allcols, $cols),
	'allcolumns' => $allcols,
));
