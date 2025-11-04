<?php
include_once 'db.php';

if (isset($_POST['submit'])) {
    // Get form data
    $productName = trim($_POST['productName']);
    $productCategory = trim($_POST['productCategory']);
    $price = trim($_POST['price']);
    $status = $_POST['status'];
    $description = trim($_POST['description']);

    // Image file handle
    $image = rand(100, 999) . '-' . date('mdY') . $_FILES['productImage']['name'];
    $tmp_name = $_FILES['productImage']['tmp_name'];

    // Store errors with an array
    $errors = [];

    // Validation for each filed
    if (empty($productName) || empty($productCategory) || empty($price) || empty($status) || empty($description) || empty($_FILES['productImage']['name'])) {
        $errors[] = "Every field is required!";
    }

    // If any filed blank not upload to database
    if (!empty($errors)) {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => implode(', ', $errors)
        ];
        header("Location: ../category-add.php?error=validation");
        exit();
    }

    // Image Upload directory
    $uploadDir = "../upload/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . $image;

    $sql = "INSERT INTO products "
}