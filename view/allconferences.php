<?php

echo $tpl->render(array(
	'page' => 'allconferences',
	'title' => 'Multiple Events',

	'conferences' => Conferences::getActiveConferences(),
));
