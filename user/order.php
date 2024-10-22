<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// Check if an order has been marked as received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    // Delete the order from the database
    $delete_query = "DELETE FROM orders WHERE id = :order_id AND user_id = :user_id";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $delete_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $delete_stmt->execute();

    // Use JavaScript alert for confirmation
    echo "<script>alert('Thank you for trusting our market!');</script>";

    // Optionally: You could redirect or show a success message
    header("Location: order.php");
    exit;
}

// Fetch user's orders from the database
$query = "SELECT o.id AS order_id, o.total_amount, o.order_date, 
          p.product_name, s.store_name, od.quantity
          FROM orders o 
          JOIN order_details od ON o.id = od.order_id 
          JOIN products p ON od.product_id = p.id 
          JOIN seller s ON p.seller_id = s.id 
          WHERE o.user_id = :user_id 
          ORDER BY o.order_date DESC";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group orders by order ID
$order_list = [];
foreach ($orders as $order) {
    $order_id = $order['order_id'];
    $store_name = $order['store_name'];

    // Initialize the order if it doesn't exist
    if (!isset($order_list[$order_id])) {
        $order_list[$order_id] = [
            'total_amount' => $order['total_amount'],
            'order_date' => $order['order_date'],
            'stores' => [],
        ];
    }

    // Add the store and product information to the order
    if (!isset($order_list[$order_id]['stores'][$store_name])) {
        $order_list[$order_id]['stores'][$store_name] = [];
    }
    
    $order_list[$order_id]['stores'][$store_name][] = [
        'name' => $order['product_name'],
        'quantity' => $order['quantity'],
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="container mt-4">
    <h1>My Orders</h1>

    <?php if (empty($orders)): ?>
        <p>You have not placed any orders yet.</p>
    <?php else: ?>
        <?php foreach ($order_list as $order_id => $order_details): ?>
            <div class="border p-3 mb-3 rounded">
                <h4>Order ID: <?php echo htmlspecialchars($order_id); ?></h4>
                <p><strong>Total Amount:</strong> ₱<?php echo number_format($order_details['total_amount'], 2); ?></p>
                <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($order_details['order_date'])); ?></p>
                
                <h5>Stores and Products:</h5>
                <?php foreach ($order_details['stores'] as $store_name => $products): ?>
                    <div class="mb-2">
                        <strong>Store Name:</strong> <?php echo htmlspecialchars($store_name); ?>
                        <ul>
                            <?php foreach ($products as $product): ?>
                                <li><?php echo htmlspecialchars($product['quantity']); ?> x <?php echo htmlspecialchars($product['name']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>

                <!-- Order Received Button -->
                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to mark this order as received?');">
                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                    <button type="submit" class="btn btn-success">Order Received</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
