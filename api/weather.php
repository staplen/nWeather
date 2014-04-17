<?php

require_once('config.php');

$query = urlencode($_GET['query']);
$response = file_get_contents($config['combined_url']."/geolookup/conditions/q/$query.json");
echo $response;

?>