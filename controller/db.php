<?php

$dbservername = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbtablename = 'eshop_task';

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbtablename);

if ($conn->connect_error) {
    die('Error-' . $conn->connect_error);
}

session_start();
?>