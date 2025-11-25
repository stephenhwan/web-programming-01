<?php 
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_login();

$message = '';
$users = get_users($pdo);
$modules = get_modules($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $userId = (int)($_POST['user_id'] ?? 0);
    $moduleId = (int)($_POST['module_id'] ?? 0);
    
    if ($title === '') {
        $message = 'Please enter question title';
    } elseif ($content === '') {
        $message = 'Please enter question details';
    } elseif ($userId <= 0) {
        $message = 'Please select a user';
    } elseif ($moduleId <= 0) {
        $message = 'Please select a module';
    } else {
        $uploadResult = handle_file_upload($_FILES['picture'] ?? []);
        
        if (!$uploadResult['success']) {
            $message = $uploadResult['error'];
        } else {
            create_question($pdo, [
                'title' => $title,
                'content' => $content,
                'picture' => $uploadResult['path'],
                'user_id' => $userId,
                'module_id' => $moduleId
            ]);
            
            header('Location: forum.php');
            exit;
        }
    }
}

ob_start();
include __DIR__ . '/templates/template_forum/addquestion.html.php'; 
$output = ob_get_clean();

include_layout();
?>