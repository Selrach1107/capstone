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
    header("Location: login_form.php");
    exit;
}

$seller_id = $_SESSION['seller_id'];

// Check if product_id is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve the product information
    $query = "SELECT * FROM products WHERE id = ? AND seller_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $product_id, $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<script>alert('Product not found!'); window.location.href='product_list.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid product ID!'); window.location.href='product_list.php';</script>";
    exit;
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $unit_price = $_POST['unit_price'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $product['image']; // Keep the existing image by default

    // Handle file upload if a new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $image = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    $update_query = "UPDATE products SET category_id = ?, product_name = ?, unit_price = ?, price = ?, description = ?, image = ? WHERE id = ? AND seller_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("issdssii", $category_id, $product_name, $unit_price, $price, $description, $image, $product_id, $seller_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href='product_list.php';</script>";
    } else {
        echo "<script>alert('Error updating product.');</script>";
    }
    $update_stmt->close();
}

$conn->close();
?>

<h2>Update Product</h2>
<form method="POST" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>

    <label for="category_id">Category:</label>
    <select name="category_id" required>
        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);
        $category_result = $conn->query("SELECT id, category_name FROM categories WHERE seller_id = $seller_id");
        while ($row = $category_result->fetch_assoc()) {
            $selected = ($row['id'] == $product['category_id']) ? 'selected' : '';
            echo "<option value='{$row['id']}' $selected>{$row['category_name']}</option>";
        }
        ?>
    </select><br>

    <label for="unit_price">Unit Price (per kilo or per piece):</label>
    <input type="text" name="unit_price" value="<?php echo $product['unit_price']; ?>" required><br>

    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo $product['description']; ?></textarea><br>

    <label for="image">Product Image:</label>
    <input type="file" name="image" accept="image/*"><br>
    <img src="<?php echo $product['image']; ?>" width="100" height="100"><br>

    <input type="submit" value="Update Product">
</form>
