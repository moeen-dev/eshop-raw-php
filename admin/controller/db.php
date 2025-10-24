<?php

$dbservername = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbtablename = 'userinfo';

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbtablename);

if ($conn->connect_error) {
    die('Error-' . $conn->connect_error);
}

session_start();
?>