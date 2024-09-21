<?php
include '../conn.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updates = [];
        $params = [':id' => $product_id];

        if (isset($_POST['product_name']) && !empty($_POST['product_name'])) {
            $updates[] = "product_name = :name";
            $params[':name'] = $_POST['product_name'];
        }

        if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
            $updates[] = "category_id = :category_id";
            $params[':category_id'] = $_POST['category_id'];
        }

        if (isset($_POST['description']) && !empty($_POST['description'])) {
            $updates[] = "description = :description";
            $params[':description'] = $_POST['description'];
        }

        if (isset($_POST['price']) && !empty($_POST['price'])) {
            $updates[] = "price = :price";
            $params[':price'] = $_POST['price'];
        }

        if (isset($_POST['price_type']) && !empty($_POST['price_type'])) {
            $updates[] = "price_type = :price_type";
            $params[':price_type'] = $_POST['price_type'];
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            $target = "uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $updates[] = "image = :image";
            $params[':image'] = $image;
        }

        if (!empty($updates)) {
            $sql = "UPDATE products SET " . implode(", ", $updates) . " WHERE product_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        
            echo "<script>
                    alert('Product updated successfully!');
                    window.location.href = 'prodlist.php';
                  </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Bootstrap 5 CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome for Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php
include 'sidebar.php';
?>

<div class="container mt-5">
    <h2>Update Product</h2>
    <form action="update_product.php?id=<?= $product_id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" id="product_name" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>">
        </div>
        <div class="mb-3">
            <label for="price_type" class="form-label">Unit</label>
            <select name="price_type" id="price_type" class="form-control" required>
                <option value="Per Piece" <?= ($product['price_type'] == 'Per Piece') ? 'selected' : '' ?>>Per Piece</option>
                <option value="Per Kilo" <?= ($product['price_type'] == 'Per Kilo') ? 'selected' : '' ?>>Per Kilo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


</body>
</html>
