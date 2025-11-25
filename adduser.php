<?php
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_admin(); // ✅ Đã có session trong auth.php

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $user_password = trim($_POST['user_password'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $user_type = trim($_POST['user_type'] ?? '');
    $passwordHash = password_hash($user_password, PASSWORD_DEFAULT);
    if ($username === '') {
        $message = 'Please enter username';
    } else {
        try {
            create_user($pdo, [
                'username' => $username,
                'user_password' => $passwordHash,
                'email' => $email,
                'user_type' => $user_type
        ]);
            $_SESSION['flash'] = 'User "' . htmlspecialchars($username) . '" created successfully!';
            header('Location: user.php');
            exit;
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
}

ob_start();
include __DIR__ . '/templates/template_user/adduser.html.php';
$output = ob_get_clean();

include_layout();
?>