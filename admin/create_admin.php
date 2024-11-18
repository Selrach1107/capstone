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

// Username at password
$username = 'admin';
$password = 'admin123'; // Ang password na gusto mo

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Mag-insert ng admin account sa database
    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    // execute  statement
    $stmt->execute();

    echo "Admin account created successfully. Hashed password: " . $hashedPassword;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;
?>
