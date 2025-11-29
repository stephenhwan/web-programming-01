<?php
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';



$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = 'Invalid user ID';
    header('Location: user.php');
    exit;
}

try {
    $deleted = delete_user($pdo, $id);
    if ($deleted > 0) {
        $_SESSION['flash'] = 'User deleted successfully!';
    } else {
        $_SESSION['flash'] = 'User not found';
    }
} catch (Exception $e) {
    $_SESSION['flash'] = 'Error: ' . $e->getMessage();
}

header('Location: user.php');
exit;
?>