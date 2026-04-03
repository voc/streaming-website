<?php
if(!$conference->hasFeedback())
	throw new NotFoundException('Feedback is disabled');

$info = $_POST;

$feedback = $conference->getFeedback();
if($feedback->validate($info))
{
	$OUTPUT_JSON = true;

	$feedback->store($info);

	header('Content-Type: application/json');
	echo json_encode(true);
	exit;
}

echo $tpl->render(array(
	'page' => 'feedback',
	'title' => 'Give Feedback',
));
