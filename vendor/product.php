<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pamilihannet";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details from the database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Update Product</h2>
    <form action="product_handler.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
        <input type="hidden" name="action" value="update">

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price_unit" class="form-label">Price Unit</label>
            <select class="form-select" id="price_unit" name="price_unit" required>
                <option value="per piece" <?php if ($product['price_unit'] === 'per piece') echo 'selected'; ?>>Per Piece</option>
                <option value="per kilo" <?php if ($product['price_unit'] === 'per kilo') echo 'selected'; ?>>Per Kilo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="quantity_unit" class="form-label">Quantity Unit</label>
            <select class="form-select" id="quantity_unit" name="quantity_unit" required>
                <option value="piece" <?php if ($product['quantity_unit'] === 'piece') echo 'selected'; ?>>Piece</option>
                <option value="kilo" <?php if ($product['quantity_unit'] === 'kilo') echo 'selected'; ?>>Kilo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if ($product['image']): ?>
                <img src="<?php echo htmlspecialchars($product['image']); ?>" width="100" alt="Current Product Image">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
