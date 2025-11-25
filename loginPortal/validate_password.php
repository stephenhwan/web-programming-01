<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
session_start();

// Kiểm tra xem đã validate username chưa
if (!isset($_SESSION['temp_username']) || !isset($_SESSION['temp_user_id'])) {
    $_SESSION['loginMessage'] = "Please start from username";
    header("Location: username_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = trim($_POST['password'] ?? '');

    // Kiểm tra bỏ trống
    if ($pass === '') {
        $_SESSION['loginMessage'] = "Please enter password";
        header("Location: password_login.php");
        exit;
    }

    // Lấy user theo ID
    $sql = "SELECT * FROM Users WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_SESSION['temp_user_id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra password
    if ($row && password_verify($pass, $row['user_password'])) {
        // Login thành công
        $_SESSION['username']  = $row['username'];
        $_SESSION['user_type'] = $row['user_type'] ?? 'user';
        
        // Xóa temp session
        unset($_SESSION['temp_username']);
        unset($_SESSION['temp_user_id']);

        header("Location: ../index.php");
        exit;
    } else {
        // Sai password
        $_SESSION['loginMessage'] = "Password incorrect";
        header("Location: password_login.php");
        exit;
    }
}

// Nếu không phải request POST → quay về trang password
header("Location: password_login.php");
exit;
?>