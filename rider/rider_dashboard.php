<?php
include '../conn.php';

session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'rider') {
    header('Location: ../index.php'); // Redirect to login page if not authorized
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard</title>
</head>
<body>
    <h4>Welcome Rider</h4>\
    <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">log out</a>
</body>
</html>