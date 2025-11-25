<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_login() {
    if (!isset($_SESSION['username'])) {
        header("Location: loginPortal/username_login.php");
        exit;
    }
}

function check_admin() {
    check_login(); // Kiểm tra login trước
    
    if ($_SESSION['user_type'] !== 'admin') {
        $_SESSION['flash'] = 'Access Denied: Admin only!';
        header("Location: index.php");
        exit;
    }
}

function include_layout() {
    // ✅ Đảm bảo $output được truyền vào scope
    global $output;
    
    if ($_SESSION['user_type'] === 'admin') {
        include __DIR__ . '/../templates/admin_layout.html.php';
    } else {
        include __DIR__ . '/../templates/user_layout.html.php';
    }
}

