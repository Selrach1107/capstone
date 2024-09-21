<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['id'])) {
    header('Location: login_form.php'); 
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'] ?? ''; 
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $store_name = $_POST['store_name'];
    $business_permit_number = $_POST['business_permit_number'];


    $sql = "UPDATE vendor SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, 
            phone_number = :phone_number, email = :email, store_name = :store_name, 
            business_permit_number = :business_permit_number WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'last_name' => $last_name,
        'phone_number' => $phone_number,
        'email' => $email,
        'store_name' => $store_name,
        'business_permit_number' => $business_permit_number,
        'id' => $user_id
    ]);

    header('Location: profile.php?update=success');
    exit();
}
?>
