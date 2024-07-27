<?php
session_start();
require 'config/db_connect.php';

// If the user is logged in, clear the remember me token
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $query = "UPDATE bnb SET login_token = NULL, login_token_expiration = NULL WHERE user = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Clear the "Remember Me" cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, "/");
}

// Destroy session
session_unset();
session_destroy();

// Redirect to index page
header("Location: /");
exit();
?>
