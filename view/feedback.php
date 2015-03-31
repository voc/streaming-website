<?php

$feedback = new Feedback();
$info = $_POST;

if(!$feedback->validate($info)) {
	echo $tpl->render(array(
		'page' => 'feedback',
		'title' => 'Give Feedback',
		'room' => null,
	));
}
else
{
	$feedback->store($info);
	echo 1;
}
