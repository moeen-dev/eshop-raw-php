<?php
include_once 'db.php';

if (isset($_POST['register'])) {
    $name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmed_password = $_POST['confirm_password'];

    $errors = [];

    // Making password hash
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // validation rule
    if (empty($name) || empty($email) || empty($password) || empty($confirmed_password)) {
        $errors[] = 'All fields are required!';
    } else {
        // confirmed password
        if ($password !== $confirmed_password) {
            $errors[] = 'Password do not matched!';
        }
    }

    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format!';
    }


    // Insert data to admins table
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../register.php");
        exit();
    } else {
        $sql = "INSERT INTO admins (`user_name`, `email`, `password`) VALUES ('$name', '$email', '$passwordHash')";
        $query = $conn->query($sql);

        if ($query == TRUE) {
            $_SESSION['success'] = 'Register Successfully! Please Login.';
            header("Location: ../login.php");
            exit();
        } else {
            $_SESSION['errors'] = 'Database Connection Failed!';
            header("Location: ../register.php");
            exit();
        }
    }
}
