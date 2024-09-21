<?php
session_start();
include '../conn.php'; // Assuming this contains the PDO connection

// Check if the user is logged in (assuming id is stored in session)
if (!isset($_SESSION['id'])) {
    echo "You are not logged in!";
    exit;
}

$vendor_id = $_SESSION['id']; // Use id from session

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new password and confirm password
    if ($new_password !== $confirm_password) {
        echo "New password and confirm password do not match!";
        exit;
    }

    // Hash the new password
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Check if the current password is correct
    $query = "SELECT password FROM vendor WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $vendor_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Verify current password
        if (password_verify($current_password, $result['password'])) {
            // Update password
            $update_query = "UPDATE vendor SET password = :new_password WHERE id = :id";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bindValue(':new_password', $hashed_new_password);
            $update_stmt->bindValue(':id', $vendor_id);

            if ($update_stmt->execute()) {
                echo "Password successfully updated!";
            } else {
                echo "Error updating password!";
            }
        } else {
            echo "Current password is incorrect!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!-- HTML Form to Change Password -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <form action="change_pass.php" method="POST">
        <label for="current_password">Current Password:</label><br>
        <input type="password" name="current_password" required><br><br>

        <label for="new_password">New Password:</label><br>
        <input type="password" name="new_password" required><br><br>

        <label for="confirm_password">Confirm New Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <input type="submit" value="Change Password">
    </form>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
