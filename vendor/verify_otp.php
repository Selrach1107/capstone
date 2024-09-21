<?php
session_start();
include '../conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp_input = $_POST['otp'];

    if ($otp_input == $_SESSION['otp']) {
        echo "OTP verified! You can now reset your password.";
        // Redirect to reset password page
        header("Location: reset_pass.php");
        exit();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Verify OTP</h2>
        <form action="verify_otp.php" method="POST">
            <div class="form-group">
                <label for="otp">Enter the OTP sent to your email:</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</body>
</html>
