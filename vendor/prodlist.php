<?php
include '../conn.php';

$sql = "SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap 5 CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome for Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <!-- Chart.js for Graphs -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>


<?php
include 'sidebar.php';
?>
    <div class="container mt-5">
    <h2>Product List</h2>
    <table class="table table-success">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Unit</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td><?= htmlspecialchars($product['category_name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?></td>
                <td><?= htmlspecialchars($product['price_type']) ?></td>
                <td>
                    <?php if (!empty($product['image_path']) && file_exists($product['image_path'])) { ?>
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="Product Image" width="50">
                    <?php } else { ?>
                        No Image
                    <?php } ?>
                </td>
                <td>
                    <a href="update_product.php?id=<?= htmlspecialchars($product['product_id']) ?>">Update</a> |
                    <a href="delete_product.php?id=<?= htmlspecialchars($product['product_id']) ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


</body>
</html>
