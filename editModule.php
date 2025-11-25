<?php
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_admin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash'] = 'Invalid Module ID';
    header('Location: module.php');
    exit;
}

$module = get_module_by_id($pdo, $id);
if (!$module) {
    $_SESSION['flash'] = 'Module not found';
    header('Location: module.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_name = trim($_POST['module_name'] ?? '');
    
    if ($module_name === '') {
        $message = 'Module name cannot be empty';
    } else {
        try {
            update_module($pdo, $id, ['module_name' => $module_name]);
            $_SESSION['flash'] = 'Module updated successfully!';
            header('Location: module.php');
            exit;
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
}

ob_start();
include __DIR__ . '/templates/template_module/editModule.html.php';
$output = ob_get_clean();

include_layout();
?>