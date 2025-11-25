<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username'] ?? '');

    // Kiểm tra bỏ trống
    if ($name === '') {
        $_SESSION['loginMessage'] = "Please enter username";
        header("Location: username_login.php");
        exit;
    }

    // Kiểm tra username có tồn tại không
    $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $name]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Username tồn tại, lưu vào session và chuyển sang bước 2
        $_SESSION['temp_username'] = $row['username'];
        $_SESSION['temp_user_id'] = $row['id'];
        header("Location: password_login.php");
        exit;
    } else {
        // Username không tồn tại
        $_SESSION['loginMessage'] = "Username not found";
        header("Location: username_login.php");
        exit;
    }
}

// Nếu không phải request POST → quay về trang login
header("Location: username_login.php");
exit;
?>