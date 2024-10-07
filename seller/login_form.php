<?php
include '../conn.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM seller WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $seller['password'])) {
            
            $_SESSION['seller_id'] = $seller['id'];
            $_SESSION['seller_email'] = $seller['email'];
            $_SESSION['role'] = 'seller'; 
            header("Location: seller_dashboard.php"); 
            exit();
        } else {
            echo "
            <script>
                alert('Invalid password.');
                window.location.href = 'http://localhost/project';
            </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('No vendor found with that email.');
                window.location.href = 'http://localhost/project';
            </script>
            ";
    }
}
?>
<!--DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
            <h2 class="text-center">Welcome Seller!</h2>
            <p class="text-center">Fill your login details.</p>
            <form action="login_form.php" method="POST">
                <input type="hidden" name="user_type" value="seller">               
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
               
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                
                <h6 class="text-center">Create account? <a href="reg_form.php">Sign Up</a></h6>
                <h6 class="text-center">
                    <a href="../endpoint/seller_forgot_pass.php">Forgot Password?</a>
                </h6>
                <button type="submit" class="btn btn-secondary form-control">Login</button>
            </form>
</body>
</html>-->
