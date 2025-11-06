<?php
include_once 'db.php';

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];

    $item = [
        'id' => $product_id,
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'quantity' => $quantity
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $product_id) {
            $cart_item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $item;
    }

    header("Location: ../cart-product.php");
    exit;
}

// Update 
if (isset($_POST['update_quantity'])) {
    $id = $_POST['id'];
    $quantity = max(1, (int)$_POST['quantity']);

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] = $quantity;
            break;
        }
    }
}

header("Location: ../cart-product.php");
