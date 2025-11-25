<?php
require __DIR__ . '/includes/DatabaseConnection.php'; 
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_admin(); 

$users = get_users($pdo);

// ✅ Render template
ob_start();
include __DIR__ . '/templates/template_user/user.html.php';  
$output = ob_get_clean();

include_layout();
?>