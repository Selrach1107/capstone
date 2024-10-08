<?php
session_start();

// I-clear  lahat ng session variables
$_SESSION = array();

// Tanggalin ang session cookie kung ito ay set
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Redirect sa login page
header("Location: ../index.php");
exit();
?>
