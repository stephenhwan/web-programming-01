<?php
require __DIR__ . '/includes/DatabaseConnection.php';
require __DIR__ . '/includes/DatabaseFunction.php';
require __DIR__ . '/loginPortal/auth.php';

check_login();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: forum.php');
    exit;
}

$question = get_question_by_id($pdo, $id);
if (!$question) {
    header('Location: forum.php');
    exit;
}

$users = get_users($pdo);
$modules = get_modules($pdo);
$message = '';

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
        $updateData = [
            'title' => $title,
            'content' => $content,
            'user_id' => $userId,
            'module_id' => $moduleId
        ];
        
        $uploadResult = handle_file_upload($_FILES['picture'] ?? []);
        
        if (!$uploadResult['success']) {
            $message = $uploadResult['error'];
        } else {
            if ($uploadResult['path'] !== null) {
                // Xóa file cũ
                if (!empty($question['picture'])) {
                    $oldFile = __DIR__ . '/' . $question['picture'];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $updateData['picture'] = $uploadResult['path'];
            }
            
            update_question($pdo, $id, $updateData);
            header('Location: forum.php');
            exit;
        }
    }
}

$currentTitle = $question['title'];
$currentContent = $question['content'];

ob_start();
include __DIR__ . '/templates/template_forum/editquestion.html.php';
$output = ob_get_clean();
include_layout();
?>