<?php
session_start();
include '../conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$seller_id = $_GET['seller_id'] ?? ''; // Assuming you're passing the seller ID via GET parameter

// Handle search and category filter (optional)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Retrieve the list of products for the selected seller
$query = "SELECT products.*, categories.category_name 
          FROM products 
          JOIN categories ON products.category_id = categories.id 
          WHERE products.seller_id = :seller_id";

$params = [':seller_id' => $seller_id]; // Parameters array for PDO binding

if (!empty($search)) {
    $query .= " AND products.product_name LIKE :search";
    $params[':search'] = "%" . $search . "%";  // Add search term to parameters
}

if (!empty($category_filter)) {
    $query .= " AND products.category_id = :category";
    $params[':category'] = $category_filter;  // Add category filter to parameters
}

$query_stmt = $conn->prepare($query);
$query_stmt->execute($params);
$result = $query_stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Products</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Custom CSS to ensure image consistency -->
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .product-card img {
            width: 100%;
            height: 250px;  /* Ensure a fixed image height */
            object-fit: contain;  /* Ensure the image fits without being distorted */
            background-color: #faf8fa;
        }
        .separator {
            border-bottom: 1px solid #ddd;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .search-filter-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="container mt-4">
        <h2>Products from Seller</h2>

        <!-- Search and Filter Form (optional) -->
        <form class="search-filter-form row g-3" method="GET" action="">
            <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>"> <!-- Ensure seller_id is retained -->
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" placeholder="Search products" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php
                    // Fetch all categories from the seller
                    $category_query = "SELECT id, category_name FROM categories WHERE seller_id = :seller_id";
                    $category_stmt = $conn->prepare($category_query);
                    $category_stmt->execute([':seller_id' => $seller_id]);
                    $category_result = $category_stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($category_result as $category_row) {
                        $selected = ($category_filter == $category_row['id']) ? "selected" : "";
                        echo "<option value='{$category_row['id']}' $selected>{$category_row['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search</button>
                <!--<a href="store_product.php?seller_id=<?php echo $seller_id; ?>" class="btn btn-secondary">Reset</a>-->
            </div>
        </form>

        <!-- Product List -->
        <div class="row">
            <?php foreach ($result as $row) : ?>
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="../seller/<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <div class="separator"></div>  
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text">
                                <strong>Category: </strong><?php echo $row['category_name']; ?><br>
                                <strong>Unit: </strong> <?php echo $row['unit_price']; ?><br>
                                <strong>Price: </strong> ₱<?php echo number_format($row['price'], 2); ?><br>
                                <strong>Description: </strong> <?php echo $row['description']; ?>
                            </p>
                            <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
