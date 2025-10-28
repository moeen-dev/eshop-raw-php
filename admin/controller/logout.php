<?php

$_SESSION = [];

session_destroy();

if (isset($_COOKIE['email'])) {
    setcookie("email", "", time() - 3600, "/", "", false, true);
}
if (isset($_COOKIE['password'])) {
    setcookie("password", "", time() - 3600, "/", "", false, true);
}

session_start();
$_SESSION['toastr'] = [
    'type' => 'info',
    'message' => 'You have been logged out successfully!'
];

header("Location: ../login.php");
exit;
