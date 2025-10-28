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
    $dir = "../upload/" . $image;

    $sql = "INSERT INTO categories (`name`, `image`) VALUES ('$name', '$image')";

    if (move_uploaded_file($tmp_name, $dir)) {
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
