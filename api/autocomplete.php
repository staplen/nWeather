<?php

$query = urlencode($_GET['query']);
$response = file_get_contents("http://autocomplete.wunderground.com/aq?query=$query");
echo $response;

?>