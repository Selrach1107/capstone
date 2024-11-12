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
$query = "SELECT products.id AS product_id, products.product_name, products.price, products.unit_price, cart.quantity, 
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

// Check if the form to update quantity was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];
    
    // Update the cart quantity in the database
    if ($new_quantity > 0) { // Only update if quantity is greater than 0
        $update_query = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
        $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $update_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $update_stmt->execute();

        // Redirect to the same page to reflect changes
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
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
                    <th>Unit</th>
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
                    <td><?php echo htmlspecialchars($item['unit_price']); ?></td>
                    <td>
                        <form action="" method="POST" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                            <button type="submit" name="update_quantity" class="btn btn-info btn-sm">Update</button>
                        </form>
                    </td>
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
