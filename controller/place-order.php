<?php

include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $address    = $_POST['address'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $notes      = $_POST['notes'];
    $cart       = $_SESSION['cart'] ?? [];

    $erorrs = [];

    if (count($cart) === 0) {
        header("Location: ../checkout.php");
        exit;
    }

    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Save order info (example)
    $sql_order = "INSERT INTO orders (`first_name`, `last_name`, `address`, `phone`, `email`, `notes`, `total`) 
                  VALUES ('$first_name', '$last_name', '$address', '$phone', '$email', '$notes', '$subtotal')";
    $query_order = $conn->query($sql_order);

    if ($query_order) {
        $order_id = $conn->insert_id; // get last inserted order id

        // Insert each cart item
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $quantity   = $item['quantity'];
            $price      = $item['price'];
            $sql_item = "INSERT INTO order_items (`order_id`, `product_id`, `quantity`, `price`)
                         VALUES ('$order_id', '$product_id', '$quantity', '$price')";
            $conn->query($sql_item);
        }

        // Clear cart
        unset($_SESSION['cart']);
        setcookie('cart_data', '', time() - 3600, "/");

        header("Location: ../index.php");
        exit;
    } else {
        echo "Order failed: " . $conn->error;
    }
}
