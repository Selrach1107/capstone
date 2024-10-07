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
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id']; 


// Change Password
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    echo "<script>alert('New password and confirm password do not match!');</script>";
    exit;
}

$hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

$query = "SELECT password FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($current_password, $row['password'])) {
        $update_query = "UPDATE user SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('si', $hashed_new_password, $user_id);

        if ($update_stmt->execute()) {
            echo "
            <script>
                alert('Password successfully updated!');
                window.location.href = 'http://localhost/project/user/profile.php';
            </script>
            ";
        } else {
            echo "<script>alert('Error updating password!');</script>";
        }
        $update_stmt->close(); // close the update statement
    } else {
        echo "
        <script>
            alert('Current password is incorrect!');
            window.location.href = 'http://localhost/project/user/profile.php';
        </script>
        ";
    }
} else {
    echo "<script>alert('User not found!');</script>";
}

$stmt->close(); // close the statement para sa user verification


$conn->close();
?>



