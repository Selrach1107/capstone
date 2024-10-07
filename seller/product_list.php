<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if seller is logged in
if (!isset($_SESSION['seller_id'])) {
    header("Location: index.php");
    exit;
}

$seller_id = $_SESSION['seller_id'];

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM products WHERE id = ? AND seller_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("ii", $delete_id, $seller_id);
    if ($delete_stmt->execute()) {
        echo "<script>alert('Product deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting product.');</script>";
    }
    $delete_stmt->close();
}

// Handle search and category filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Retrieve categories for the dropdown
$category_query = "SELECT id, category_name FROM categories WHERE seller_id = ?";
$category_stmt = $conn->prepare($category_query);
$category_stmt->bind_param("i", $seller_id);
$category_stmt->execute();
$category_result = $category_stmt->get_result();

// Retrieve the list of products for the current seller with search and category filter
$query = "SELECT products.*, categories.category_name 
          FROM products 
          JOIN categories ON products.category_id = categories.id 
          WHERE products.seller_id = ?";

if (!empty($search)) {
    $query .= " AND products.product_name LIKE ?";
    $search = "%" . $search . "%";
}

if (!empty($category_filter)) {
    $query .= " AND products.category_id = ?";
}

$query_stmt = $conn->prepare($query);

// Bind the parameters dynamically based on the filters
if (!empty($search) && !empty($category_filter)) {
    $query_stmt->bind_param("isi", $seller_id, $search, $category_filter);
} elseif (!empty($search)) {
    $query_stmt->bind_param("is", $seller_id, $search);
} elseif (!empty($category_filter)) {
    $query_stmt->bind_param("ii", $seller_id, $category_filter);
} else {
    $query_stmt->bind_param("i", $seller_id);
}

$query_stmt->execute();
$result = $query_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .card-img-top {
            height: 250px;  /* Set image height */
            object-fit: contain;  /* Ensure full image is shown */
            background-color: #faf8fa;  /* Light background to highlight image boundaries */
        }
        .card-body {
            text-align: left;  /* Center align text for cleaner appearance */
        }
        .card-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 15px;  /* Add space after the separator line */
        }
        .separator {
            border-bottom: 1px solid #ddd;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .search-filter-form {
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>

</head>
<body>

<?php
    include 'sidebar.php';
?>

<div class="container mt-4">
    <h2>PRODUCTS</h2>

    <!-- Search and Filter Form -->
    <form class="search-filter-form row g-3" method="GET" action="">
        <div class="col-md-4">
            <input type="text" class="form-control" name="search" placeholder="Search Product Name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        </div>
        <div class="col-md-4">
            <select class="form-select" name="category">
                <option value="">All Categories</option>
                <?php while ($category = $category_result->fetch_assoc()) : ?>
                    <option value="<?php echo $category['id']; ?>" <?php if ($category_filter == $category['id']) echo 'selected'; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="product_list.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Product Cards -->
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-4">
                <div class="card product-card">
                    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <div class="separator"></div>  
                        <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                        <p class="card-text ">
                            <strong>Category: </strong><?php echo $row['category_name']; ?><br>
                            <strong>Unit: </strong> <?php echo $row['unit_price']; ?><br>
                            <strong>Price: </strong> ₱<?php echo number_format($row['price'], 2); ?><br>
                            <strong>Description: </strong> <?php echo $row['description']; ?>
                        </p>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        <a href="update_product.php?product_id=<?php echo $row['id']; ?>" class="btn btn-custom btn-sm">Update</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
