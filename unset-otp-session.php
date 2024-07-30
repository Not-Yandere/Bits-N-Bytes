<?php
session_start();
unset($_SESSION['otp']);
unset($_SESSION['new_email']);
echo json_encode(['status' => 'success']);
?>
