<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    // Check if the category already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE category_name = ?");
    $stmt->execute([$category_name]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert the new category
        $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$category_name]);
        $success_message = "Category added successfully.";
    } else {
        $error_message = "Category already exists.";
    }

    header("Location: add_category.php");
    exit();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->execute([$category_id]);
    header("Location: add_category.php"); 
    exit();
}

// Fetch categories from database
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
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <?php
        include 'sidebar.php';
    ?>

<div class="d-flex justify-content-center">
    <div class="card w-50 mt-4">
        <h5 class="card-header">CATEGORY</h5>
        <div class="card-body">
            <div class="container mt-2">
                <form action="add_category.php" method="POST">
                    <div class="mb-3">
                        <input type="text" name="category_name" placeholder="Enter Category Name" class="form-control" required>
                        <button type="submit" class="btn btn-primary mt-2">Add Category</button>
                    </div>
                </form>
                <br>
                <?php if (isset($success_message)) { ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
                <?php } ?>
                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Category List</h2>
    <table class="table table-success">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)) { ?>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td><?= htmlspecialchars($category['category_id']) ?></td>
                        <td><?= htmlspecialchars($category['category_name']) ?></td>
                        <td>
                            <a href="add_category.php?delete=<?= $category['category_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3">No categories found.</td>
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
