<?php

$feedback = new Feedback();
if(!$feedback->isEnabled())
	throw new NotFoundException('Feedback is disabled');

$info = $_POST;

if($feedback->validate($info))
{
	$feedback->store($info);

	header('Content-Type: application/json');
	echo json_encode(true);
	exit;
}

echo $tpl->render(array(
	'page' => 'feedback',
	'title' => 'Give Feedback',
));
