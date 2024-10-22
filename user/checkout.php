<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items along with the store name for the logged-in user
$query = "SELECT s.store_name, p.product_name, p.price, c.quantity, p.id AS product_id 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          JOIN seller s ON p.seller_id = s.id  -- Join seller table to get store name
          WHERE c.user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'sidebar.php' ?>

<div class="container mt-4">
    <h1>Checkout</h1>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty. Please add items to your cart before checking out.</p>
        <a href="cart.php" class="btn btn-primary">Go to Cart</a>
    <?php else: ?>
        <h2>Cart Items</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['store_name']); ?></td> 
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td> 
                        <td>₱<?php echo number_format($item['price'], 2); ?></td> 
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td> 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total Amount: ₱<?php echo number_format($total_amount, 2); ?></h3>

        <h2>Shipping Information</h2>
        <form action="place_order.php" method="POST">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="address">Shipping Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <button type="submit" class="btn btn-success">Confirm Order</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
