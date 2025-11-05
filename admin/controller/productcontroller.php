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
            header("Location: ../product-list.php");
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


// Update Logic
if (isset($_POST['update'])) {
    // Get form data
    $id = $_POST['id'];
    $productName = trim($_POST['productName']);
    $productCategory = trim($_POST['productCategory']);
    $price = trim($_POST['price']);
    $status = $_POST['status'];
    $description = trim($_POST['description']);

    // old image check
    $oldImageQuery = $conn->query("SELECT image FROM products WHERE id = $id");
    $oldImage = '';
    if ($oldImageQuery->num_rows > 0) {
        $oldImage = $oldImageQuery->fetch_assoc()['image'];
    }

    // Store errors with an array
    $errors = [];

    // Validation for each filed
    if (empty($productName) || empty($productCategory) || empty($price) || empty($status) || empty($description)) {
        $errors[] = "Every field is required!";
    }

    // Check product name for unique
    $checkSql = "SELECT * FROM products WHERE name = '$productName' AND id != '$id'";
    $checkQuery = $conn->query($checkSql);
    if ($checkQuery->num_rows > 0) {
        $errors[] = 'Product Name Already exists!';
    }

    if (empty($oldImage) && empty($_FILES['productImage']['name'])) {
        $errors[] = 'Image is required!';
    }

    // If any filed blank not upload to database
    if (!empty($errors)) {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => implode(', ', $errors)
        ];
        header("Location: ../product-edit.php?id=$id&error=validation");
        exit();
    }

    if (!empty($_FILES['productImage']['name'])) {
        $image = rand(10, 99) . '-' . date('mdY') . '-' . basename($_FILES['productImage']['name']);
        $tmp_name = $_FILES['productImage']['tmp_name'];
        $uploadDir = "../upload/";
        $filePath = $uploadDir . $image;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($tmp_name, $filePath)) {
            $_SESSION['toastr'] = [
                'type' => 'error',
                'message' => 'Image upload failed!'
            ];
            header("Location: ../product-edit.php?id=$id&error=upload");
            exit();
        }

        // Old image delete
        if (!empty($oldImage) && file_exists("../upload/" . $oldImage)) {
            unlink("../upload/" . $oldImage);
        }
        // update all field 
        $sql = "UPDATE products 
                SET name='$productName', 
                    category_id='$productCategory', 
                    price='$price', 
                    status='$status', 
                    description='$description', 
                    image='$image' 
                WHERE id = $id";
    } else {
        // Update without image
        $sql = "UPDATE products 
                SET name='$productName', 
                    category_id='$productCategory', 
                    price='$price', 
                    status='$status', 
                    description='$description' 
                WHERE id = $id";
    }

    $query = $conn->query($sql);

    if ($query === TRUE) {
        $_SESSION['toastr'] = [
            'type' => 'success',
            'message' => 'Product Updated Successfully!'
        ];
        header("Location: ../product-list.php");
        exit();
    } else {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => 'Database update failed!'
        ];
        header("Location: ../product-edit.php?id=$id&error=db");
        exit();
    }
}


// product destroy
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);

    $imgSql = "SELECT image FROM products WHERE id = $id";
    $imgQuery = $conn->query($imgSql);

    if ($imgQuery->num_rows > 0) {
        $rowImage = $imgQuery->fetch_assoc();
        $image = $rowImage['image'];
        $imagePath = "../upload/" . $image;

        if (!empty($image) && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $sql = "DELETE FROM products WHERE id = $id";
    $query = $conn->query($sql);

    if ($query) {
        $_SESSION['toastr'] = [
            'type' => 'success',
            'message' => 'Product deleted successfully!'
        ];
    } else {
        $_SESSION['toastr'] = [
            'type' => 'error',
            'message' => 'Failed to delete Product!'
        ];
    }

    header("Location: ../product-list.php");
    exit();
}
