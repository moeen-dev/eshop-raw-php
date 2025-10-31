<?php
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
