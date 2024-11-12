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

if (!isset($_SESSION['seller_id'])) {
    header("Location: index.php");
    exit;
}

$seller_id = $_SESSION['seller_id'];

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $deleteQuery = "DELETE FROM categories WHERE id = ? AND seller_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $delete_id, $seller_id);

    if ($deleteStmt->execute()) {
        $message = "Category deleted successfully!";
        $alert_type = "success";
    } else {
        $message = "Error deleting category.";
        $alert_type = "danger";
    }

    $deleteStmt->close();
}

$query = "SELECT * FROM categories WHERE seller_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        // JavaScript to hide the alert message after 3 seconds
        document.addEventListener("DOMContentLoaded", function() {
            const alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                setTimeout(function() {
                    alertMessage.style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">CATEGORIES</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-<?php echo $alert_type; ?>" id="alertMessage" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-success table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = 1; // Counter variable for displaying IDs sequentially
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>

</body>
</html>

