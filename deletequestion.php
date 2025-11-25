<?php
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = 'Invalid question ID';
    header('Location: forum.php');
    exit;
}

try {
    $result = delete_question($pdo, $id);
    
    // Xóa file ảnh nếu có
    if ($result['picture'] && file_exists(__DIR__ . $result['picture'])) {
        unlink(__DIR__ . $result['picture']);
    }
    
    if ($result['deleted'] > 0) {
        $_SESSION['flash'] = 'Question deleted successfully!';
    } else {
        $_SESSION['flash'] = 'Question not found';
    }
} catch (Exception $e) {
    $_SESSION['flash'] = 'Error: ' . $e->getMessage();
}

header('Location: forum.php');
exit;
?>