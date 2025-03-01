<?php
$host = '192.168.0.9';
$dbname = 'BookDB';
$username = 'root';
$password = '';
$port = 3306;

$mysqli = new mysqli($host, $username, $password, $dbname, $port);

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

?>
