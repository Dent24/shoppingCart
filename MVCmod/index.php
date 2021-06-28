<?php

require_once("./Routes.php");

$url = $_GET['url'];
$check = new Route();

$check->getView($url); 

?>