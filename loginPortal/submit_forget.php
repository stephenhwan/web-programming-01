<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';
session_start();

// Kiểm tra xem đã validate username chưa
if (!isset($_SESSION['temp_username']) || !isset($_SESSION['temp_user_id'])) {
    $_SESSION['loginMessage'] = "Please login first to reset password";
    header("Location: username_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['temp_user_id'];
    $newPassword = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');
    
    // Validation
    if ($newPassword === '') {
        $_SESSION['resetMessage'] = 'Password cannot be empty';
        $_SESSION['resetMessageType'] = 'error';
        header('Location: forget_password.php');
        exit;
    }
    
    if (strlen($newPassword) < 6) {
        $_SESSION['resetMessage'] = 'Password must be at least 6 characters';
        $_SESSION['resetMessageType'] = 'error';
        header('Location: forget_password.php');
        exit;
    }
    
    if ($newPassword !== $confirmPassword) {
        $_SESSION['resetMessage'] = 'Passwords do not match';
        $_SESSION['resetMessageType'] = 'error';
        header('Location: forget_password.php');
        exit;
    }
    
    try {
        // ĐÃ CÓ MÃ HÓA: Sử dụng password_hash() - đây là cách đúng
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $updateData = [
            'user_password' => $hashedPassword
        ];
        
        update_user($pdo, $user_id, $updateData);
        
        // Xóa temp session
        unset($_SESSION['temp_username']);
        unset($_SESSION['temp_user_id']);
        
        // Thông báo thành công
        $_SESSION['loginMessage'] = '✅ Password reset successfully! Please login with new password';
        
        // ĐÃ SỬA: Thêm exit() ngay sau header để đảm bảo redirect
        header('Location: username_login.php');
        exit();
        
    } catch (Exception $e) {
        $_SESSION['resetMessage'] = 'Error: ' . $e->getMessage();
        $_SESSION['resetMessageType'] = 'error';
        header('Location: forget_password.php');
        exit();
    }
}

// Nếu không phải POST request
header('Location: forget_password.php');
exit();
?>