<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $user_password = trim($_POST['user_password'] ?? '');
    $user_type = 'user';
    $email = '';
    
    if ($username === '' || $user_password === '') {
        $_SESSION['loginMessage'] = 'Please fill all fields';
        $_SESSION['loginMessageType'] = 'error';
        header('Location: register_user.php'); 
        exit();
    } 
    
    try {
        $passwordHash = password_hash($user_password, PASSWORD_DEFAULT);
        create_user($pdo, [
            'username' => $username,
            'user_password' => $passwordHash,
            'user_type' => $user_type,
            'email' => $email
        ]);
        $_SESSION['loginMessage'] = '✅ Registration successful! You can now log in.';
        $_SESSION['loginMessageType'] = 'success';
        header('Location: username_login.php'); 
        exit();
    } catch (Exception $e) {
        $_SESSION['loginMessage'] = 'Error: ' . $e->getMessage();
        $_SESSION['loginMessageType'] = 'error';
        header('Location: register_user.php'); 
        exit();
    }
}

header('Location: register_user.php');
exit();
?>