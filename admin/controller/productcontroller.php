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
    $tmp_name = $_FILES['categoryImage']['tmp_name'];

    $errors = [];

    // Erorr handling
    if (empty($productName) || empty($productCategory) || empty($price) || empty($status) || empty($description) || empty($_FILES['productImage']['name'])) {
        $errors = "Every fileds are required!";
    }

    // If any field blank not upload 
    if (!empty($errors)) {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => implode(', ', $errors)
        ];
        header("Location: ../product-add.php?error=validation");
        exit();
    }
}