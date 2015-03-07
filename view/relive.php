<?php

echo $tpl->render(array(
	'page' => 'relive',
	'title' => 'Relive!',
	'talks' => relive_talks(),
));
