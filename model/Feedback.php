<?php

class Feedback
{
	private $conference;

	public function __construct(Conference $conference)
	{
		$this->conference = $conference;
	}

	private function get($key) {
		return $this->conference->has(['FEEDBACK', $key])
			? $this->conference->get(['FEEDBACK', $key])
			: @$GLOBALS['CONFIG']['FEEDBACK'][$key];
	}

	public function getConference() {
		return $this->conference;
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
		$db = new PDO($this->get('DSN'));
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stm = $db->prepare('
			INSERT INTO feedback (reported, datetime, net, os, player, stream, ipproto_v4, ipproto_v6, provider, issues, issuetext)
				VALUES (:reported, :datetime, :net, :os, :player, :stream, :ipproto_v4, :ipproto_v6, :provider, :issues, :issuetext)
		');

		$issuetext = preg_replace('/\r?\n/', ' ', $info['issuetext']);

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
			'issuetext' => $issuetext,
		));
	}

	public function isLoggedIn()
	{
		return
			isset($_SERVER['PHP_AUTH_USER']) &&
			$_SERVER['PHP_AUTH_USER'] == $this->get('USERNAME') &&
			$_SERVER['PHP_AUTH_PW'] == $this->get('PASSWORD');
	}

	public function requestLogin()
	{
		header('WWW-Authenticate: Basic realm="Kadse?"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'You are no real Winkekatzenoperator!!!1!';
		exit;
	}

	public function read($from, $to)
	{
		$db = new PDO($this->get('DSN'));
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stm = $db->prepare('
			SELECT *
			 FROM feedback
			 WHERE reported BETWEEN :from AND :to
			 ORDER BY reported DESC
		');
		$stm->setFetchMode(PDO::FETCH_ASSOC);

		$stm->execute(array(
			'from' => $from,
			'to' => $to,
		));

		return $stm;
	}
}
