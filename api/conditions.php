<?php

require_once('config.php');

$query = $_GET['query'];
$response = file_get_contents($config['combined_url']."/conditions$query.json");
echo $response;

?>