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

function get_user_full_name($mysqli, $user_id)
{
    $sql = 'SELECT GetFullName(?) AS full_name';
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['full_name'];
}

?>
