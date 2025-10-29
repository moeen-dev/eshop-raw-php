<?php
include_once 'db.php';

if (isset($_POST['submit'])) {
    // Get form Data
    $categoryName = trim($_POST['categoryName']);
    $image = rand() . date('m-d-Y') . "-" . $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $errors = [];

    // Validation
    if (empty($categoryName) || empty($image['name'])) {
        $errors[] = 'Category name and image are required!';
    }

    // Image Upload directory
    $uploadDir  = "../upload/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . $imageName;

    $sql = "INSERT INTO categories (`name`, `image`) VALUES ('$categoryName', '$image')";

    if (move_uploaded_file($tmp_name, $filePath )) {
        $query = $conn->query($sql);

        if ($query == TRUE) {
            header("Location: ../category-list.php");
        } else {
            header("Location: ../category-add.php?error=save error");
        }
    } else {
        header("Location: ../category-add.php?error=upload error");
    }
}
