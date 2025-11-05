<?php
include_once 'db.php';

if (isset($_POST['submit'])) {
    // Get form Data
    $categoryName = trim($_POST['categoryName']);
    $image = rand(100, 999) . '-' . date('mdY') . "-" . $_FILES['categoryImage']['name'];
    $tmp_name = $_FILES['categoryImage']['tmp_name'];

    $errors = [];

    // Validation
    if (empty($categoryName) || empty($_FILES['categoryImage']['name'])) {
        $errors[] = 'Category name and image are required!';
    }

    // If any field blank not upload
    if (!empty($errors)) {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => implode(', ', $errors)
        ];
        header("Location: ../category-add.php?error=validation");
        exit();
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

// Update logic
if (isset($_POST['update'])) {
    // Get form Data
    $id = $_POST['id'];
    $categoryName = trim($_POST['categoryName']);
    $errors = [];

    // old image check
    $oldImageQuery = $conn->query("SELECT image FROM categories WHERE id = $id");
    $oldImage = '';
    if ($oldImageQuery->num_rows > 0) {
        $oldImage = $oldImageQuery->fetch_assoc()['image'];
    }

    // Validation
    if (empty($categoryName)) {
        $errors[] = 'Category name is required!';
    }

    // Check category name for unique
    $checkSql = "SELECT * FROM categories WHERE name = '$categoryName' AND id != '$id'";
    $checkQuery = $conn->query($checkSql);
    if ($checkQuery->num_rows > 0) {
        $errors[] = 'Category name already exits!';
    }

    if (empty($oldImage) && empty($_FILES['categoryImage']['name'])) {
        $errors[] = 'Image is required!';
    }

    // If any field blank not upload
    if (!empty($errors)) {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => implode(', ', $errors)
        ];
        header("Location: ../category-edit.php?id=$id&error=validation");
        exit();
    }

    if (!empty($_FILES['categoryImage']['name'])) {
        $image = rand(100, 999) . '-' . date('mdY') . "-" . basename($_FILES['categoryImage']['name']);
        $tmp_name = $_FILES['categoryImage']['tmp_name'];
        $uploadDir = "../upload/";
        $filePath = $uploadDir . $image;

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (!move_uploaded_file($tmp_name, $filePath)) {
            $_SESSION['toastr'] = [
                'type' => 'error',
                'message' => 'Image upload failed!'
            ];
            header("Location: ../category-edit.php?id=$id&error=upload");
            exit();
        }

        // Delete old image if exists
        if (!empty($oldImage) && file_exists("../upload/" . $oldImage)) {
            unlink("../upload/" . $oldImage);
        }

        // Update name + image
        $sql = "UPDATE categories SET name='$categoryName', image='$image' WHERE id=$id";
    } else {
        // Update name only
        $sql = "UPDATE categories SET name='$categoryName' WHERE id=$id";
    }


    $query = $conn->query($sql);

    if ($query === TRUE) {
        $_SESSION['toastr'] = [
            'type' => 'success',
            'message' => 'Category Updated Successfully!'
        ];
        header("Location: ../category-list.php");
        exit();
    } else {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => 'Database update failed!'
        ];
        header("Location: ../category-edit.php?id=$id&error=db");
        exit();
    }
}

// Category Destroy
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);

    $imgSql = "SELECT image FROM categories WHERE id = $id";
    $imgQuery = $conn->query($imgSql);

    if ($imgQuery->num_rows > 0) {
        $rowImage = $imgQuery->fetch_assoc();
        $image = $rowImage['image'];
        $imagePath = "../upload/" . $image;

        if (!empty($image) && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $sql = "DELETE FROM categories WHERE id = $id";
    $query = $conn->query($sql);

    if ($query) {
        $_SESSION['toastr'] = [
            'type' => 'success',
            'message' => 'Category deleted successfully!'
        ];
    } else {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => 'Failed to delete category!'
        ];
    }

    header("Location: ../category-list.php");
    exit();
}
