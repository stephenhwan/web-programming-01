<?php
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_admin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash'] = 'Invalid user ID';
    header('Location: user.php');
    exit;
}

$user = get_user_by_id($pdo, $id);
if (!$user) {
    $_SESSION['flash'] = 'User not found';
    header('Location: user.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['user_password'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if ($username === '') {
        $message = 'Username cannot be empty';
    } else {
        try {
            $updateData = [
                'username' => $username,
                'email' => $email
            ];
            
            if (!empty($password)) {
                $updateData['user_password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            
            update_user($pdo, $id, $updateData);
            $_SESSION['flash'] = 'User updated successfully!';
            header('Location: user.php');
            exit;
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
}

ob_start();
include __DIR__ . '/templates/template_user/edituser.html.php';
$output = ob_get_clean();

include_layout();
?>