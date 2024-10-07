<?php
$host = 'localhost'; 
$db = 'project'; 
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';

// Set the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES => false, // Use native prepared statements
];

try {
    // Create a new PDO instance
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Handle connection error
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
