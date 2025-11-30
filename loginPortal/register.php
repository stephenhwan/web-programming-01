<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $user_password = 'user1234';
    $user_type = 'user';
    $email = trim($_POST['email'] ?? '');
    
    if ($username === '' || $email === '') {
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
        
        // ✅ LƯU THÔNG TIN VÀO SESSION
        $_SESSION['new_user_username'] = $username;
        $_SESSION['new_user_password'] = $user_password;
        $_SESSION['new_user_email'] = $email;
        
        // ✅ REDIRECT ĐẾN TRANG TERMS (bước 1)
        header('Location: term.php'); 
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