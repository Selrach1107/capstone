<?php
include '../conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

// Get the selected seller ID
if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];

    // Get all products for this seller
    $query = "SELECT * FROM products WHERE seller_id = :seller_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all products for the seller
} else {
    header('Location: dashboard.php'); // Redirect back if no seller is selected
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'sidebar.php' ?>
    <div class="container mt-4">
        <h4>Products from the Store</h4>
        <div class="row">
            <?php foreach ($products as $row): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text">₱<?php echo number_format($row['price'], 2); ?></p>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
