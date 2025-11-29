<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = trim($_POST['password'] ?? '');

    if ($pass === '') {
        $_SESSION['loginMessage'] = "Please enter password";
        $_SESSION['loginMessageType'] = 'error';
        header("Location: password_login.php");
        exit;
    }

    $sql = "SELECT * FROM Users WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_SESSION['temp_user_id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['user_password'])) {
        $_SESSION['username']  = $row['username'];
        $_SESSION['user_type'] = $row['user_type'] ?? 'user';
        
        unset($_SESSION['temp_username']);
        unset($_SESSION['temp_user_id']);

        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['loginMessage'] = "Password incorrect";
        $_SESSION['loginMessageType'] = 'error';
        header("Location: password_login.php");
        exit;
    }
}

header("Location: password_login.php");
exit;
?>