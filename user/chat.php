<?php
include '../conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: ../index.php');
    exit();
}

// Get the user ID
$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session

// Handle form submission (sending a message)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $receiver_id = $_POST['receiver_id']; // ID of the person you're chatting with
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO chats (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $receiver_id, $message]);
}

// Fetch the chat messages between the user and the selected receiver
if (isset($_GET['receiver_id'])) {
    $receiver_id = $_GET['receiver_id'];
    $stmt = $conn->prepare("SELECT * FROM chats WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC");
    $stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>