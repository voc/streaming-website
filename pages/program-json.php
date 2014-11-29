<?php

require_once('lib/bootstrap.php');

header('Content-Type: application/json');
echo json_encode(program());
