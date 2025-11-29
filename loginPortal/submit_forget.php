<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';
session_start();

// Kiểm tra session username
if (!isset($_SESSION['temp_username'])) {
    $_SESSION['loginMessage'] = 'Session expired. Please try again.';
    header('Location: username_login.php');
    exit;
}

// Chỉ chấp nhận POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: forget_password.php');
    exit;
}

$username = $_SESSION['temp_username'];
$newPassword = trim($_POST['new_password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

// Validation
if ($newPassword === '') {
    $_SESSION['resetMessage'] = 'Password cannot be empty';
    $_SESSION['resetMessageType'] = 'error';
    header('Location: forget_password.php');
    exit;
}

if ($confirmPassword === '') {
    $_SESSION['resetMessage'] = 'Confirm password cannot be empty';
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

if (strlen($newPassword) < 8) {
    $_SESSION['resetMessage'] = 'Password must be at least 8 characters';
    $_SESSION['resetMessageType'] = 'error';
    header('Location: forget_password.php');
    exit;
}

try {
    $sql = "SELECT id FROM Users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user || !isset($user['id'])) {
        $_SESSION['loginMessage'] = 'User not found. Please try again.';
        unset($_SESSION['temp_username']);
        header('Location: username_login.php');
        exit;
    }
    
    $userId = (int)$user['id'];
    
    if ($userId <= 0) {
        throw new Exception('Invalid user ID');
    }
    
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateData = ['user_password' => $hashedPassword];
    
    // Thực hiện update
    $rowsUpdated = update_user($pdo, $userId, $updateData);
    
    // Xóa temp session
    unset($_SESSION['temp_username']);
    
    // ✅ Set thông báo thành công
    $_SESSION['loginMessage'] = '✅ Password reset successfully! Please login with your new password.';
    $_SESSION['loginMessageType'] = 'success';

    header('Location: username_login.php');
    exit;
    
} catch (PDOException $e) {
    $_SESSION['resetMessage'] = 'Database error occurred. Please try again later.';
    $_SESSION['resetMessageType'] = 'error';
    error_log('Password reset DB error: ' . $e->getMessage());
    header('Location: forget_password.php');
    exit;
    
} catch (Exception $e) {
    $_SESSION['resetMessage'] = 'Error: ' . $e->getMessage();
    $_SESSION['resetMessageType'] = 'error';
    error_log('Password reset error: ' . $e->getMessage());
    header('Location: forget_password.php');
    exit;
}
?>