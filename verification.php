<?php 
   $servername = "localhost"; // your database server
   $username = "root"; // your database username
   $password = ""; // your database password
   $dbname = "pamilihannet";
   
   try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Failed " . $e->getMessage();
    }
    session_start();

    if (isset($_SESSION['user_verification_id'])) {
        $userVerificationID = $_SESSION['user_verification_id'];
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with Email Verification</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

</head>
<body>
    
    <div class="main">

        <!-- Email Verification Area -->

        <div class="verification-container">

            <div class="verification-form" id="loginForm">
                <h2 class="text-center">Email Verification</h2>
                <p class="text-center">Please check your email for verification code.</p>
                <form action="./endpoint/add-user.php" method="POST">
                    <input type="text" name="user_verification_id" value="<?= $userVerificationID ?>" hidden>
                    <input type="number" class="form-control text-center" id="verificationCode" name="verification_code">
                    <button type="submit" class="btn btn-secondary login-btn form-control mt-4" name="verify">Verify</button>
                </form>
            </div>

        </div>

    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>