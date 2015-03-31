<?php

class Feedback extends ModelBase
{
	public function isEnabled() {
		return $this->has('FEEDBACK');
	}
	public function getUrl() {
		return 'feedback/';
	}

	public function validate($info)
	{
		return
			isset($_POST['datetime']) ||
			isset($_POST['net']) ||
			isset($_POST['os']) ||
			isset($_POST['player']) ||
			isset($_POST['stream']) ||
			isset($_POST['provider']) ||
			isset($_POST['issuetext']);
	}

	public function store($info)
	{
		$db = new PDO($this->get('FEEDBACK.DSN'));
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stm = $db->prepare('
			INSERT INTO feedback (reported, datetime, net, os, player, stream, ipproto_v4, ipproto_v6, provider, issues, issuetext)
				VALUES (:reported, :datetime, :net, :os, :player, :stream, :ipproto_v4, :ipproto_v6, :provider, :issues, :issuetext)
		');

		$stm->execute(array(
			'reported' => time(),
			'datetime' => strtotime($info['datetime']),
			'net' => $info['net'],
			'os' => $info['os'],
			'player' => $info['player'],
			'stream' => $info['stream'],
			'ipproto_v4' => isset($info['ipproto']) && is_array($info['ipproto']) && in_array('v4', $info['ipproto']),
			'ipproto_v6' => isset($info['ipproto']) && is_array($info['ipproto']) && in_array('v6', $info['ipproto']),
			'provider' => $info['provider'],
			'issues' => isset($info['issues']) && is_array($info['issues']) ? implode(',', $info['issues']) : '',
			'issuetext' => $info['issuetext'],
		));
	}
}
