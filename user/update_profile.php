<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if seller is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

$seller_id = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'] ?? ''; 
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
   


    $sql = "UPDATE user SET first_name = ?, middle_name = ?, last_name = ?, 
            phone_number = ?, email = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind the parameters to the statement
    $stmt->bind_param("sssssi", $first_name, $middle_name, $last_name, $phone_number, $email, $seller_id);


    if ($stmt->execute()) {
        header('Location: profile.php?update=success');
        exit();
    } else {
        echo "<script>alert('Error updating profile: ');</script>" . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
