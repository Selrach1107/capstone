<?php
session_start(); // Start session at the top of the script

// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

// Registration Process
if (isset($_POST['register'])) {
    try {
        // Capture form data
        $firstName = $_POST['first_name'];
        $middleName = $_POST['middle_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password


        // Check for duplicates
        $duplicateMsg = '';

        // Check phone number
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `user` WHERE `phone_number` = :phone_number");
        $stmt->execute(['phone_number' => $phoneNumber]);
        if ($stmt->fetchColumn() > 0) {
            $duplicateMsg .= 'Phone number already exists. ';
        }

        // Check email
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `user` WHERE `email` = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            $duplicateMsg .= 'Email address already exists. ';
        }


        if ($duplicateMsg === '') {
            $verificationCode = rand(100000, 999999);

            // Store form data and verification code in the session
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['form_data'] = [
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'password' => $hashedPassword // Store hashed password
            ];

            // Send verification email
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lorem.ipsum.sample.email@gmail.com'; // Replace with your email
            $mail->Password   = 'novtycchbrhfyddx'; // Replace with your app password
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('lorem.ipsum.sample.email@gmail.com', 'Lorem Ipsum');
            $mail->addAddress($email);
            $mail->addReplyTo('lorem.ipsum.sample.email@gmail.com');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your verification code is: ' . $verificationCode;
            $mail->send();

            echo "
            <script>
                alert('Check your email for the verification code.');
                window.location.href = 'http://localhost/project/user/user-verification.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('$duplicateMsg Please use different details.');
                window.location.href = 'http://localhost/project/#userRegModal';
            </script>
            ";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Verification Process
if (isset($_POST['verify'])) {
    try {
        $verificationCode = $_POST['verification_code'];

        // Check if the entered code matches the one stored in the session
        if (isset($_SESSION['verification_code']) && intval($_SESSION['verification_code']) === intval($verificationCode)) {
            // Retrieve the stored form data from the session
            $formData = $_SESSION['form_data'];

            // Insert the account data into the registration_requests table
            $insertStmt = $conn->prepare("INSERT INTO `user` 
                (`first_name`, `middle_name`, `last_name`, `phone_number`, `email`, `password`, `verification_code`) 
                VALUES (:first_name, :middle_name, :last_name, :phone_number, :email, :password, :verification_code)");

            $insertStmt->bindParam(':first_name', $formData['first_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':middle_name', $formData['middle_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $formData['last_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':phone_number', $formData['phone_number'], PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $formData['email'], PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $formData['password'], PDO::PARAM_STR); // Use hashed password
            $insertStmt->bindParam(':verification_code', $verificationCode, PDO::PARAM_INT);
            $insertStmt->execute();

            // Clear the session after successful verification
            session_unset();
            session_destroy();

            echo "
            <script>
                alert('Registration successfully');
                window.location.href = 'http://localhost/project/#userLoginModal';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Incorrect Verification Code. Try Again.');
                window.location.href = 'http://localhost/project/user/user-verification.php';
            </script>
            ";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
