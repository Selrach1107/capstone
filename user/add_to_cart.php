<?php
include '../conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id']; 

    // Prepare the SQL query to add the product to the cart
    $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)";
    $stmt = $conn->prepare($query);
    
    // Bind the parameters using PDO
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    
    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the cart page or show a success message
        header('Location: cart.php');
    } else {
        echo "Error adding product to cart.";
    }
} else {
    echo "No product selected.";
}
?>
