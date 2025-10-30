<?php
include_once 'db.php';

if (isset($_POST['submit'])) {
    // Get form Data
    $categoryName = trim($_POST['categoryName']);
    $image = rand() . date('m-d-Y') . "-" . $_FILES['categoryImage']['name'];
    $tmp_name = $_FILES['categoryImage']['tmp_name'];

    $errors = [];

    // Validation
    if (empty($categoryName) || empty($_FILES['categoryImage']['name'])) {
        $errors[] = 'Category name and image are required!';
    }

    // Image Upload directory
    $uploadDir  = "../upload/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . $image;

    $sql = "INSERT INTO categories (`name`, `image`) VALUES ('$categoryName', '$image')";
    $query = $conn->query($sql);


    if (move_uploaded_file($tmp_name, $filePath)) {

        if ($query == TRUE) {
            $_SESSION['toastr'] = [
                'type' => 'success',
                'message' => 'Category Added Successful!'
            ];
            header("Location: ../category-list.php");
            exit();
        } else {
            $_SESSION['toastr'] = [
                'type' => 'error',
                'message' => 'Something Went Wrong!'
            ];
            header("Location: ../category-add.php?error=save error");
            exit();
        }
    } else {
        $_SESSION['toastr'] = [
            'type' => 'info',
            'message' => 'Upload Failed!'
        ];
        header("Location: ../category-add.php?error=upload error");
        exit();
    }
}
