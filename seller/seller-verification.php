<?php 
 include '../conn.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h2 class="text-center">Email Verification</h2>
    <p class="text-center">Please check your email for verification code.</p>
    <form action="../endpoint/add-seller.php" method="POST">
        <input type="text" name="user_verification_id" value="<?= $userVerificationID ?>" hidden>
        <input type="number" class="form-control text-center" id="verificationCode" name="verification_code">
        <button type="submit" class="btn btn-secondary login-btn form-control mt-4" name="verify">Verify</button>
    </form>
</body>
</html>