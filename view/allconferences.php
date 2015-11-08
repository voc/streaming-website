<?php

echo $tpl->render(array(
	'page' => 'allconferences',
	'title' => 'Multiple Conferences',

	'conferences' => Conferences::getActiveConferences(),
));
