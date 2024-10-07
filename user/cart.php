<?php
include '../conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to get cart items for the current user
$query = "SELECT products.id AS product_id, products.product_name, products.price, cart.quantity, 
                 (products.price * cart.quantity) AS total_price
          FROM cart
          INNER JOIN products ON cart.product_id = products.id
          WHERE cart.user_id = :user_id";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate the total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['total_price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="path/to/your/bootstrap.css">
</head>
<body>
<?php include 'sidebar.php' ?>

<div class="container">
    <h1>Your Cart</h1>

    <?php if (count($cart_items) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['total_price'], 2); ?></td>
                    <td>
                        <a href="remove_from_cart.php?product_id=<?php echo $item['product_id']; ?>" class="btn btn-danger">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-right">
            <h3>Total Amount: ₱<?php echo number_format($total_amount, 2); ?></h3>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<script src="path/to/your/bootstrap.js"></script>
</body>
</html>
