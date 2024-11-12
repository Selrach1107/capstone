<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the shipping details and total amount
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $total_amount = $_POST['total_amount'];

    // Prepare the order insertion query
    $insert_order_query = "INSERT INTO orders (user_id, full_name, address, phone, total_amount, order_date) 
                           VALUES (:user_id, :full_name, :address, :phone, :total_amount, NOW())";
    $stmt = $conn->prepare($insert_order_query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
    
    // Execute the query and check if successful
    if ($stmt->execute()) {
        // Get the last inserted order ID
        $order_id = $conn->lastInsertId();

        // Fetch cart items to insert into order details
        $cart_query = "SELECT product_id, quantity FROM cart WHERE user_id = :user_id";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $cart_stmt->execute();
        $cart_items = $cart_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Insert each cart item into the order details
        foreach ($cart_items as $item) {
            $insert_order_details_query = "INSERT INTO order_details (order_id, product_id, quantity) 
                                            VALUES (:order_id, :product_id, :quantity)";
            $order_details_stmt = $conn->prepare($insert_order_details_query);
            $order_details_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $order_details_stmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
            $order_details_stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
            $order_details_stmt->execute();
        }

        // Clear the cart after placing the order
        $delete_cart_query = "DELETE FROM cart WHERE user_id = :user_id";
        $delete_cart_stmt = $conn->prepare($delete_cart_query);
        $delete_cart_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $delete_cart_stmt->execute();

        // Order placed successfully
        echo "<script>
        alert('Thank you, " . htmlspecialchars($full_name) . ". Your order has been placed successfully!\\nTotal Amount: ₱" . number_format($total_amount, 2) . "');
        window.location.href = 'order.php';
        </script>";


    } else {
        echo "<div class='container mt-4'><h2>Error placing the order. Please try again.</h2></div>";
    }
} else {
    header("Location: checkout.php");
    exit;
}
?>
