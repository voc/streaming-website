<?php

namespace C3VOC\StreamingWebsite\Model;

echo $tpl->render(array(
	'page' => 'allconferences',
	'title' => 'Multiple Conferences',

	'conferences' => Conferences::getActiveConferences(),
));
