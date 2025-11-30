<?php
session_start();


// ✅ Kiểm tra thông tin user
if (!isset($_SESSION['new_user_username']) || 
    !isset($_SESSION['new_user_password']) || 
    !isset($_SESSION['new_user_email'])) {
    header('Location: register_user.php');
    exit();
}

$_SESSION['send_welcome_email'] = true;


header('Location: ../contact.php');
exit();
?>