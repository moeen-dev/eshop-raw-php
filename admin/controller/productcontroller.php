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
        header("Location: ../product-add.php?error=validation");
        exit();
    }

    // Image Upload directory
    $uploadDir = "../upload/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . $image;

    $sql = "INSERT INTO products (`name`, `category_id`, `image`, `price`, `status`, `description`) VALUES ('$productName', '$productCategory', '$image', '$price', '$status', '$description')";
    $query = $conn->query($sql);

    if (move_uploaded_file($tmp_name, $filePath)) {

        if ($query == TRUE) {
            $_SESSION['toastr'] = [
                'type' => 'success',
                'message' => 'Product Added Successful!'
            ];
            header("Location: ../product-add.php?error=save error");
        } else {
            $_SESSION['toastr'] = [
                'type' => 'error',
                'message' => 'Something Went Wrong!'
            ];
            header("Location: ../product-add.php?error=save error");
            exit();
        }
    } else {
        $_SESSION['toastr'] = [
            'type' => 'info',
            'message' => 'Upload Failed!'
        ];
        header("Location: ../product-add.php?error=upload error");
        exit();
    }
}
