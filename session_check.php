<?php

function checkAndDestroySession() {
    // Check if the user is not on the verify-otp.php page
    if (basename($_SERVER['PHP_SELF']) !== '/verify-otp') {
        // Check if the specific session variables are set
        if (isset($_SESSION['user1']) || isset($_SESSION['email1']) || isset($_SESSION['password1']) || isset($_SESSION['otp'])) {
            // Unset the session variables
            unset($_SESSION['user1']);
            unset($_SESSION['email1']);
            unset($_SESSION['password1']);
            unset($_SESSION['otp']);
        }
    }
}

// Call the function to check and destroy the session variables
checkAndDestroySession();
?>
