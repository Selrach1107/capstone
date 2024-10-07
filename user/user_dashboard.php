<?php
include '../conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

// Get all sellers from the database
$query = "SELECT id, store_name FROM seller";
$stmt = $conn->prepare($query);
$stmt->execute();
$sellers = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all sellers

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'sidebar.php' ?>

    <div class="container mt-4">
        <h4>Select a Store</h4>
        <div class="list-group">
            <?php foreach($sellers as $row): ?>
                <a href="store_products.php?seller_id=<?php echo $row['id']; ?>" class="list-group-item list-group-item-action">
                    <?php echo $row['store_name']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
