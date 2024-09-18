<?php
session_start(); // Start the session

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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT `password` FROM `vendor` WHERE `email` = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $stored_password = $row['password'];

        // Verify the hashed password
        if (password_verify($password, $stored_password)) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email; // Optionally store user email or ID for reference

            // Redirect to the dashboard
            header("Location: http://localhost/capstone/vendor/dashboard.php");
            exit();
        } else {
            echo "
            <script>
                alert('Login Failed, Incorrect Password!');
                window.location.href = 'http://localhost/capstone/vendor/login_form.php';
            </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('Login Failed, User Not Found!');
                window.location.href = 'http://localhost/capstone/vendor/login_form.php';
            </script>
            ";
    }
}
?>
