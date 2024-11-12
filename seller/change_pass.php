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
if (!isset($_SESSION['seller_id'])) {
    header("Location: index.php");
    exit;
}

$seller_id = $_SESSION['seller_id']; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

  
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirm password do not match!');</script>";
        exit;
    }

 
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    
    $query = "SELECT password FROM seller WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $seller_id); // 'i' indicates the seller_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      
        if (password_verify($current_password, $row['password'])) {
           
            $update_query = "UPDATE seller SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param('si', $hashed_new_password, $seller_id); // 'si' indicates string for password and integer for seller_id

            if ($update_stmt->execute()) {
                echo "<script>alert('Password successfully updated!');</script>";
            } else {
                echo "<script>alert('rror updating password!');</script>";
            }
        } else {
            echo "<script>alert('Current password is incorrect!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }

    
    $stmt->close();
    $update_stmt->close();
}


$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin: 50px auto;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #57f386;
            color: black;
            text-align: center;
            padding: 15px;
            font-size: 1.25rem;
            border-radius: 10px 10px 0 0;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-custom {
            background-color: #57f386;
            color: black;
        }
        .btn-custom:hover {
            background-color: #57f386;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-lock"></i> Change Password
        </div>
        <div class="card-body p-4">
            <form action="change_pass.php" method="POST">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password:</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password:</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-custom btn-block">Change Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
