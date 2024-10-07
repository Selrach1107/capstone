<?php
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


session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = 'user'; 
            header("Location: user_dashboard.php"); 
            exit();
        } else {
            echo "
            <script>
                alert('Invalid password.');
                window.location.href = 'http://localhost/project/#userLoginModal';
            </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('No vendor found with that email.');
                window.location.href = 'http://localhost/project/#userLoginModal';
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
            <h2 class="text-center">Welcome Buyer!</h2>
            <p class="text-center">Fill your login details.</p>
            <form action="login_form.php" method="POST">
                <input type="hidden" name="user_type" value="user">               
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
               
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                
                <h6 class="text-center">Create account? <a href="reg_form.php">Sign Up</a></h6>
                <h6 class="text-center">
                    <a href="../endpoint/forgot_pass.php">Forgot Password?</a>
                </h6>
                <button type="submit" class="btn btn-secondary form-control">Login</button>
            </form>
</body>
</html>-->
