<?php 
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_admin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_name = trim($_POST['module_name'] ?? '');

    if ($module_name === '') {
        $message = 'Please enter module name';
    } else {
        try {
            create_module($pdo, ['module_name' => $module_name]);
            $_SESSION['flash'] = 'Module "' . htmlspecialchars($module_name) . '" created successfully!';
            header('Location: module.php');
            exit;
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
}

ob_start();
include __DIR__ . '/templates/template_module/addModule.html.php';
$output = ob_get_clean();

include_layout();
?>