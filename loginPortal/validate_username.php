<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username'] ?? '');

    // Kiểm tra bỏ trống
    if ($name === '') {
        $_SESSION['loginMessage'] = "Please enter username";
        header("Location: username_login.php");
        exit;
    }

    // ✅ Lấy thông tin user đầy đủ
    $sql = "SELECT id, username FROM Users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['temp_username'] = $user['username'];
        $_SESSION['temp_user_id'] = $user['id'];
        header("Location: password_login.php");
        exit;
    }
    else {
        $_SESSION['loginMessage'] = "Username not found";
        header("Location: username_login.php");
        exit;
    }
}

header("Location: username_login.php");
exit;
?>