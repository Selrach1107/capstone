<?php
session_start();
include '../conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp_input = $_POST['otp'];

    if ($otp_input == $_SESSION['otp']) {
        echo "<script>
                    alert('OTP verified! You can now reset your password.');
                    window.location.href = 'http://localhost/project/rider/rider_reset_pass.php';
                  </script>";
        exit();
    } else {
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
        <h2 class="text-center">Verify OTP</h2>
        <form action="rider_verify_otp.php" method="POST">
            <div class="form-group">
                <label for="otp">Enter the OTP sent to your email:</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
</body>
</html>
