<?php
include '../conn.php';

session_start();

// Check if the user is logged in and has the admin role
/*if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header('Location: login_form.php'); // Redirect to login page if not authorized
    exit();
}*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password == $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $email = $_SESSION['email'];

        $stmt = $conn->prepare("UPDATE seller SET password = :password WHERE email = :email");
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Password has been reset successfully!');
                    window.location.href = 'http://localhost/project/seller/login_form.php';
                  </script>";
            session_destroy(); // End session after password reset
        } else {
            echo "<script>alert('Error resetting password.');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reset Password</h2>
        <form action="seller_reset_pass.php" method="POST">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>
</html>
