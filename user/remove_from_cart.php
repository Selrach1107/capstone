<?php
session_start();
require 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id']; 

// Prepare and execute the removal query
$query = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: cart.php"); // Redirect back to cart after removal
    exit;
} else {
    echo "Error removing item from cart.";
}
?>
