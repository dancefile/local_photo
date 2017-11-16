<?php
$hostname = "127.0.0.1";
$username = "dancefile";
$password = "123";
$dbName = "dancefile";

$domen='ru';
//$domen='eu';

$mysqli = new mysqli($hostname, $username, $password, $dbName);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
