<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "pamilihannet";

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

if (isset($_POST['register'])) {
    try {
        // Capture form data
        $firstName = $_POST['first_name'];
        $middleName = $_POST['middle_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $email = $_POST['email'];
        $storeName = $_POST['store_name'];
        $businessPermitNumber = $_POST['business_permit_number'];
        $businessPermitImage = $_POST['business_permit_image'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];


        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password

        // Start transaction
        $conn->beginTransaction();

        // Check for duplicates
        $duplicateMsg = '';

        // Check phone number
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `vendor` WHERE `phone_number` = :phone_number");
        $stmt->execute(['phone_number' => $phoneNumber]);
        if ($stmt->fetchColumn() > 0) {
            $duplicateMsg .= 'Phone number already exists. ';
        }

        // Check email
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `vendor` WHERE `email` = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            $duplicateMsg .= 'Email address already exists. ';
        }

        // Check store name
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `vendor` WHERE `store_name` = :store_name");
        $stmt->execute(['store_name' => $storeName]);
        if ($stmt->fetchColumn() > 0) {
            $duplicateMsg .= 'Store name already exists. ';
        }

        // Check business permit number
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `vendor` WHERE `business_permit_number` = :business_permit_number");
        $stmt->execute(['business_permit_number' => $businessPermitNumber]);
        if ($stmt->fetchColumn() > 0) {
            $duplicateMsg .= 'Business permit number already exists. ';
        }

        if ($duplicateMsg === '') {
            $verificationCode = rand(100000, 999999);

            // Insert new vendor record
            $insertStmt = $conn->prepare("INSERT INTO `vendor` (`first_name`, `middle_name`, `last_name`, `phone_number`, `email`, `store_name`, `business_permit_number`, `business_permit_image`, `password`, `verification_code`) 
            VALUES (:first_name, :middle_name, :last_name, :phone_number, :email, :store_name, :business_permit_number, :business_permit_image, :password, :verification_code)");

            $insertStmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $insertStmt->bindParam(':middle_name', $middleName, PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $insertStmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam(':store_name', $storeName, PDO::PARAM_STR);
            $insertStmt->bindParam(':business_permit_number', $businessPermitNumber, PDO::PARAM_STR);
            $insertStmt->bindParam(':business_permit_image', $businessPermitImage, PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR); // Use hashed password
            $insertStmt->bindParam(':verification_code', $verificationCode, PDO::PARAM_INT);
            $insertStmt->execute();

            // Send verification email
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lorem.ipsum.sample.email@gmail.com';
            $mail->Password   = 'novtycchbrhfyddx';
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

            // Store user ID in session
            session_start();
            $userVerificationID = $conn->lastInsertId();
            $_SESSION['user_verification_id'] = $userVerificationID;

            echo "
            <script>
                alert('Check your email for verification code.');
                window.location.href = 'http://localhost/capstone/verification.php';
            </script>
            ";

            $conn->commit();
        } else {
            echo "
            <script>
                alert('$duplicateMsg Please use different details.');
                window.location.href = 'http://localhost/capstone/reg_form.php';
            </script>
            ";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['verify'])) {
    try {
        $userVerificationID = $_POST['user_verification_id'];
        $verificationCode = $_POST['verification_code'];

        $stmt = $conn->prepare("SELECT `verification_code` FROM `vendor` WHERE `id` = :user_verification_id");
        $stmt->execute([
            'user_verification_id' => $userVerificationID
        ]);
        $codeExist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($codeExist && $codeExist['verification_code'] == $verificationCode) {
            session_destroy();
            echo "
            <script>
                alert('Registered Successfully.');
                window.location.href = 'http://localhost/capstone/vendor/login_form.php';
            </script>
            ";
        } else {
            // Delete the user if verification fails
            $deleteStmt = $conn->prepare("DELETE FROM `vendor` WHERE `id` = :user_verification_id");
            $deleteStmt->execute([
                'user_verification_id' => $userVerificationID
            ]);

            echo "
            <script>
                alert('Incorrect Verification Code. Register Again.');
                window.location.href = 'http://localhost/capstone/verification.php';
            </script>
            ";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
