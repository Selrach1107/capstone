<?php
include '../conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

// Initialize search variable
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get all sellers from the database with an optional search filter
$query = "SELECT id, store_name FROM seller WHERE store_name LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $search . "%"; // Prepare the search term for LIKE query
$stmt->bindParam(1, $searchTerm); // Bind the search term
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
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="container mt-4">
    <h4>Select a Store</h4>

    <!-- Search Bar -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for a store..." value="<?php echo htmlspecialchars($search); ?>">
            <a href="user_dashboard.php" class="btn btn-white">X</a>
            <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
        </div>
    </form>

    <div class="list-group">
        <?php if (count($sellers) > 0): ?>
            <?php foreach ($sellers as $row): ?>
                <a href="store_products.php?seller_id=<?php echo $row['id']; ?>" class="list-group-item list-group-item-action">
                    <?php echo htmlspecialchars($row['store_name']); ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="list-group-item">No stores found.</div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
