<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['id'])) {
    header('Location: login_form.php'); 
    exit();
}

$user_id = $_SESSION['id'];

$sql = "SELECT first_name, middle_name, last_name, phone_number, email, store_name, business_permit_number FROM vendor WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: login_form.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
     <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js for Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container mt-5">
    <h2>User Profile</h2>

    <div class="card mt-3">
        <div class="card-header">Personal Information</div>
        <div class="card-body">
            <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
            <p><strong>Middle Name:</strong> <?= htmlspecialchars($user['middle_name']) ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
            <p><strong>Phone Number:</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">Store Information</div>
        <div class="card-body">
            <p><strong>Store Name:</strong> <?= htmlspecialchars($user['store_name']) ?></p>
            <p><strong>Business Permit Number:</strong> <?= htmlspecialchars($user['business_permit_number']) ?></p>
        </div>
    </div>

    <form action="update_profile.php" method="post">
        <h5>Update Profile</h5>
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="middle_name">Middle Name:</label>
            <input type="text" id="middle_name" name="middle_name" value="<?= htmlspecialchars($user['middle_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="number" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <h5>Update Business Information</h5>
        <div class="form-group">
            <label for="store_name">First Name:</label>
            <input type="text" id="store_name" name="store_name" value="<?= htmlspecialchars($user['store_name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="business_permit_number">Business Permit #:</label>
            <input type="text" id="business_permit_number" name="business_permit_number" value="<?= htmlspecialchars($user['business_permit_number']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>


  <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
