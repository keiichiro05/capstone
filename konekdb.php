<?php
$server = "localhost";
$user = "root";
$password = "";
$mysqli = new mysqli($server, $user, $password, "E-pharm");

if ($mysqli->connect_error) {
	die("Connection failed: " . $mysqli->connect_error);
}

?>
