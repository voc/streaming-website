<?php

if(
	!isset($_POST['datetime']) ||
	!isset($_POST['net']) ||
	!isset($_POST['os']) ||
	!isset($_POST['player']) ||
	!isset($_POST['stream']) ||
	!isset($_POST['provider']) ||
	!isset($_POST['issuetext'])
) {
	echo $tpl->render(array(
		'page' => 'feedback',
		'title' => 'Give Feedback',
		'room' => null,
	));
}
else
{
	$db = new PDO(get('FEEDBACK.DSN'));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stm = $db->prepare('
		INSERT INTO feedback (reported, datetime, net, os, player, stream, ipproto_v4, ipproto_v6, provider, issues, issuetext)
			VALUES (:reported, :datetime, :net, :os, :player, :stream, :ipproto_v4, :ipproto_v6, :provider, :issues, :issuetext)
	');

	$stm->execute(array(
		'reported' => time(),
		'datetime' => strtotime($_POST['datetime']),
		'net' => $_POST['net'],
		'os' => $_POST['os'],
		'player' => $_POST['player'],
		'stream' => $_POST['stream'],
		'ipproto_v4' => isset($_POST['ipproto']) && is_array($_POST['ipproto']) && in_array('v4', $_POST['ipproto']),
		'ipproto_v6' => isset($_POST['ipproto']) && is_array($_POST['ipproto']) && in_array('v6', $_POST['ipproto']),
		'provider' => $_POST['provider'],
		'issues' => isset($_POST['issues']) && is_array($_POST['issues']) ? implode(',', $_POST['issues']) : '',
		'issuetext' => $_POST['issuetext'],
	));
}
