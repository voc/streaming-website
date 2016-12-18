<?php

$relive = $conference->getRelive();
if(!$relive->isEnabled())
	throw new NotFoundException('Internal Relive is disabled');

echo $tpl->render(array(
	'page' => 'relive',
	'title' => 'Relive!',
	'talks' => $relive->getTalks(),
));
