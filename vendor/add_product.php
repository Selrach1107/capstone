<?php
session_start(); 

include '../conn.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $price_type = $_POST['price_type']; // 'Per Piece' or 'Per Kilo'

   // Handle file upload
   if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
    $target_dir = "uploads/";
    $file_name = basename($_FILES["product_image"]["name"]);
    $target_file = $target_dir . $file_name;
    
    // Check if file is a valid image type
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    if (in_array($_FILES['product_image']['type'], $allowed_types)) {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            $image_path = "uploads/default_image.png";
        }
    } else {
        echo "Unsupported file type.";
        $image_path = "uploads/default_image.png";
    }
    } else {
        $image_path = "uploads/default_image.png";
    }
    
    // Insert product into the database
    if (!isset($_SESSION['upload_error'])) {
        try {
            // Check if the product already exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE product_name = ?");
            $stmt->execute([$product_name]);
            if ($stmt->fetchColumn() > 0) {
                $_SESSION['error_message'] = "Product with this name already exists.";
            } else {
                $stmt = $conn->prepare("INSERT INTO products (product_name, category_id, description, price, price_type, image_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$product_name, $category_id, $description, $price, $price_type, $image_path]);
                $_SESSION['success_message'] = "Product added successfully.";

                // Redirect to the same page to prevent resubmission on refresh
                header("Location: add_product.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error adding product: " . $e->getMessage();
        }
    }
}

// Fetch categories from the database for the dropdown
$categories = [];
try {
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <?php
        include 'sidebar.php';
    ?>

<div class="d-flex justify-content-center">
    <div class="card w-75 mt-4">
        <h5 class="card-header">Add Product</h5>
        <div class="card-body">
            <div class="container mt-2">
                <?php
                    if (isset($_SESSION['success_message'])) {
                        echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
                        unset($_SESSION['success_message']);
                    }
                    if (isset($_SESSION['error_message'])) {
                        echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
                        unset($_SESSION['error_message']);
                    }
                    if (isset($_SESSION['upload_error'])) {
                        echo "<div class='alert alert-danger'>" . $_SESSION['upload_error'] . "</div>";
                        unset($_SESSION['upload_error']);
                    }
                ?>
                <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select a Category</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?= htmlspecialchars($category['category_id']) ?>">
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_type" class="form-label">Unit</label>
                        <select name="price_type" id="price_type" class="form-control" required>
                            <option value="Per Piece">Per Piece</option>
                            <option value="Per Kilo">Per Kilo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
                <br>
                
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
