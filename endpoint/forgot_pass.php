<?php
session_start();
include '../conn.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT id FROM vendor WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP to session (temporary) for validation
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Send OTP to the user's email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your mail server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lorem.ipsum.sample.email@gmail.com'; // Your email
            $mail->Password   = 'novtycchbrhfyddx'; // Your email password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('lorem.ipsum.sample.email@gmail.com', 'PamilihanNet'); // Sender's email and name
            $mail->addAddress($email); // Add recipient email
            $mail->addReplyTo('lorem.ipsum.sample.email@gmail.com', 'PamilihanNet Support');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = 'Your OTP for password reset is <b>' . $otp . '</b>.';

            $mail->send();

            echo "OTP has been sent to your email.";

            // Redirect to OTP verification page
            header("Location: ../vendor/verify_otp.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Forgot Password</h2>
        <form action="forgot_pass.php" method="POST">
            <div class="form-group">
                <label for="email">Enter your email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>
    </div>
</body>
</html>
