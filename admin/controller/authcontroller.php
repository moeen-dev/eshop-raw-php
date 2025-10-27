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

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admins WHERE email = '$email'";
    $query = $conn->query($sql);

    if ($query && $query->num_rows > 0) {
        $user = $query->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];

            if (isset($_POST['remeber_me'])) {
                setcookie("email", $email, time() + (86400 * 30), "/");
                setcookie("password", $password, time() + (86400 * 30), "/");
            }

            $_SESSION['toastr'] = [
                'type' => 'success',
                'message' => 'Login Successful!'
            ];
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['toastr'] = [
                'type' => 'error',
                'message' => 'Wrong Password!'
            ];
        }
    } else {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => 'No user found with this email!'
        ];
    }

    header("Location: ../login.php");
    exit();
}
