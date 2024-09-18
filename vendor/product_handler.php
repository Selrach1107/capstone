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

// Function to upload the image
function uploadImage($image) {
    if ($image['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $image['tmp_name'];
        $fileName = $image['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = './uploaded_images/';
            $destPath = $uploadDir . $fileName;
            move_uploaded_file($fileTmpPath, $destPath);
            return $destPath;
        }
    }
    return null;
}

// Handle add product action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $price_unit = $_POST['price_unit'];
    $quantity = $_POST['quantity'];
    $quantity_unit = $_POST['quantity_unit'];
    $description = $_POST['description'];
    $imagePath = uploadImage($_FILES['image']);

    if ($imagePath) {
        // Insert product into the database
        $stmt = $conn->prepare("INSERT INTO products (name, price, price_unit, quantity, quantity_unit, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsiiss", $name, $price, $price_unit, $quantity, $quantity_unit, $description, $imagePath);
        if ($stmt->execute()) {
            // Redirect back to the product list page
            header("Location: vendor_products.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading the image.";
    }
}



// Handle product update action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $price_unit = $_POST['price_unit'];
    $quantity = $_POST['quantity'];
    $quantity_unit = $_POST['quantity_unit'];
    $description = $_POST['description'];
    $currentImagePath = isset($_POST['current_image']) ? $_POST['current_image'] : null;
    $imagePath = uploadImage($_FILES['image'], $currentImagePath);

    // Update product in the database
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, price_unit = ?, quantity = ?, quantity_unit = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sdsiissi", $name, $price, $price_unit, $quantity, $quantity_unit, $description, $imagePath, $id);
    if ($stmt->execute()) {
        // Redirect back to the product list page
        header("Location: vendor_products.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
