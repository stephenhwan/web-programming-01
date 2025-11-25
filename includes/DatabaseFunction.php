<?php
function db_query(PDO $pdo, string $sql, array $params = []) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function db_fetch_all(PDO $pdo, string $sql, array $params = []) {
    return db_query($pdo, $sql, $params)->fetchAll(PDO::FETCH_ASSOC);
}

function db_fetch_one(PDO $pdo, string $sql, array $params = []) {
    return db_query($pdo, $sql, $params)->fetch(PDO::FETCH_ASSOC);
}

function allowed_table(string $table): bool {
    $allowed = ['Users', 'Modules', 'Questions'];
    return in_array($table, $allowed, true);
}

// --- CRUD chung ---
function insert_row(PDO $pdo, string $table, array $data) {
    if (!allowed_table($table)) throw new InvalidArgumentException("insert_row: table not allowed: $table");
    if (empty($data)) throw new InvalidArgumentException('insert_row: empty data');

    $cols = array_keys($data);
    $colsQuoted = array_map(fn($c) => "`$c`", $cols);
    $placeholders = array_map(fn($c) => ':' . $c, $cols);

    $sql = "INSERT INTO `$table` (" . implode(',', $colsQuoted) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $pdo->prepare($sql);
    foreach ($data as $k => $v) $stmt->bindValue(':' . $k, $v);
    $stmt->execute();
    return $pdo->lastInsertId();
}

function update_row(PDO $pdo, string $table, array $data, string $whereClause, array $whereParams = []) {
    if (!allowed_table($table)) throw new InvalidArgumentException("update_row: table not allowed: $table");
    if (empty($data)) throw new InvalidArgumentException('update_row: empty data');

    $sets = [];
    foreach ($data as $col => $val) $sets[] = "`$col` = :set_$col";
    $sql = "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE " . $whereClause;

    $stmt = $pdo->prepare($sql);
    foreach ($data as $col => $val) $stmt->bindValue(':set_' . $col, $val);
    foreach ($whereParams as $k => $v) $stmt->bindValue(str_starts_with($k, ':') ? $k : ':' . $k, $v);

    $stmt->execute();
    return $stmt->rowCount();
}

function delete_row(PDO $pdo, string $table, string $whereClause, array $whereParams = []) {
    if (!allowed_table($table)) throw new InvalidArgumentException("delete_row: table not allowed: $table");
    $sql = "DELETE FROM `$table` WHERE " . $whereClause;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($whereParams);
    return $stmt->rowCount();
}

function get_all(PDO $pdo, string $table, string $orderBy = '', int $limit = 0) {
    if (!allowed_table($table)) throw new InvalidArgumentException("get_all: table not allowed: $table");
    $sql = "SELECT * FROM `$table`";
    if ($orderBy !== '') $sql .= " ORDER BY " . $orderBy;
    if ($limit > 0) $sql .= " LIMIT " . intval($limit);
    return db_fetch_all($pdo, $sql);
}

function get_by_id(PDO $pdo, string $table, string $idColumn, $id) {
    if (!allowed_table($table)) throw new InvalidArgumentException("get_by_id: table not allowed: $table");
    $sql = "SELECT * FROM `$table` WHERE `$idColumn` = :id LIMIT 1";
    return db_fetch_one($pdo, $sql, ['id' => $id]);
}

// --- USER ---
function get_users(PDO $pdo) {
    $sql = "SELECT id, username, email, user_type FROM Users ORDER BY id ASC";
    return db_fetch_all($pdo, $sql);
}

function get_user_by_id(PDO $pdo, int $id) {
    return get_by_id($pdo, 'Users', 'id', $id);
}

function create_user(PDO $pdo, array $data) {
    $allowedCols = ['username','user_password','user_type', 'email']; 
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    return insert_row($pdo, 'Users', $dataFiltered);
}
function register_user(PDO $pdo, array $data) {
    $allowedCols = ['username','user_password','user_type']; 
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    return insert_row($pdo, 'Users', $dataFiltered);
}
function update_user(PDO $pdo, int $id, array $data) {
    $allowedCols = ['username', 'user_password','email'];
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    return update_row($pdo, 'Users', $dataFiltered, 'id = :id', ['id' => $id]);
}

function delete_user(PDO $pdo, int $id) {
    return delete_row($pdo, 'Users', 'id = :id', ['id' => $id]);
}

// --- MODULES ---
function get_modules(PDO $pdo) {
    $sql = "SELECT id, module_name FROM Modules ORDER BY module_name ASC";
    return db_fetch_all($pdo, $sql);
}

function get_module_by_id(PDO $pdo, int $id) {
    return get_by_id($pdo, 'Modules', 'id', $id);
}

function create_module(PDO $pdo, array $data) {
    $allowedCols = ['module_name'];
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    return insert_row($pdo, 'Modules', $dataFiltered);
}

function delete_module(PDO $pdo, int $id) {
    return delete_row($pdo, 'Modules', 'id = :id', ['id' => $id]);
}

function update_module(PDO $pdo, int $id, array $data) {
    $allowedCols = ['module_name'];
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    return update_row($pdo, 'Modules', $dataFiltered, 'id = :id', ['id' => $id]);
}

// --- QUESTIONS ---
function get_questions(PDO $pdo) {
    $sql = "SELECT q.id, q.title, q.content, q.picture, q.created_day,
                    u.id AS user_id, u.username,
                    m.id AS module_id, m.module_name
            FROM Questions q
            JOIN Users u ON q.user_id = u.id
            JOIN Modules m ON q.module_id = m.id
            ORDER BY q.created_day DESC, q.id DESC";
    
    $questions = db_fetch_all($pdo, $sql);
    
    foreach ($questions as &$question) {
        if (!empty($question['picture'])) {
            $ext = strtolower(pathinfo($question['picture'], PATHINFO_EXTENSION));
            $question['is_video'] = in_array($ext, ['mp4', 'mov', 'mpeg']);
        } else {
            $question['is_video'] = false;
        }
    }
    
    return $questions;
}

function get_question_by_id(PDO $pdo, int $id) {
    $sql = "SELECT q.id, q.title, q.content, q.picture, q.created_day,
                    u.id AS user_id, u.username,
                    m.id AS module_id, m.module_name
            FROM Questions q
            JOIN Users u ON q.user_id = u.id
            JOIN Modules m ON q.module_id = m.id
            WHERE q.id = :id
            LIMIT 1";
    
    $question = db_fetch_one($pdo, $sql, ['id' => $id]);
    
    if ($question && !empty($question['picture'])) {
        $ext = strtolower(pathinfo($question['picture'], PATHINFO_EXTENSION));
        $question['is_video'] = in_array($ext, ['mp4', 'mov', 'mpeg']);
    } else {
        $question['is_video'] = false;
    }
    
    return $question;
}

function create_question(PDO $pdo, array $data) {
    $allowedCols = ['title','content', 'picture', 'user_id', 'module_id', 'created_day'];
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    
    if (!isset($dataFiltered['created_day'])) {
        $dataFiltered['created_day'] = date('Y-m-d H:i:s');
    }
    
    return insert_row($pdo, 'Questions', $dataFiltered);
}

function update_question(PDO $pdo, int $id, array $data) {
    $allowedCols = ['title', 'content', 'picture', 'user_id', 'module_id'];
    $dataFiltered = array_intersect_key($data, array_flip($allowedCols));
    return update_row($pdo, 'Questions', $dataFiltered, 'id = :id', ['id' => $id]);
}

function delete_question(PDO $pdo, int $id) {
    $question = get_question_by_id($pdo, $id);
    
    // Xóa file nếu có
    if ($question && !empty($question['picture'])) {
        $filePath = __DIR__ . '/../' . $question['picture'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    
    $deleted = delete_row($pdo, 'Questions', 'id = :id', ['id' => $id]);
    
    return [
        'deleted' => $deleted,
        'picture' => $question['picture'] ?? null
    ];
}

// --- XỬ LÝ UPLOAD FILE ---
function handle_file_upload($file) {
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => true, 'path' => null, 'error' => null];
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'path' => null, 'error' => 'Upload error'];
    }
    
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/mpeg', 'video/quicktime'];
    if (!in_array($file['type'], $allowed)) {
        return ['success' => false, 'path' => null, 'error' => 'Only JPG, PNG, GIF, MP4, MOV allowed'];
    }
    
    if ($file['size'] > 100 * 1024 * 1024) {
        return ['success' => false, 'path' => null, 'error' => 'File must be less than 50MB'];
    }
    
    // Tạo thư mục nếu chưa có
    $uploadDir = __DIR__ . '/../uploads/questions/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Tạo tên file unique
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = uniqid('q_') . '_' . time() . '.' . $ext;
    $targetPath = $uploadDir . $fileName;
    
    // Di chuyển file
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => false, 'path' => null, 'error' => 'Failed to move uploaded file'];
    }
    
    return ['success' => true, 'path' => 'uploads/questions/' . $fileName, 'error' => null];
}

function get_upload_script() {
    return <<<'JS'
<script>
function updateFileName(input) {
    const display = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        display.textContent = '✅ ' + file.name + ' (' + sizeMB + ' MB)';
        display.style.color = '#28a745';
    } else {
        display.textContent = '';
    }
}
</script>
JS;
}

// --- LIGHTBOX MODAL SCRIPT ---
function get_lightbox_script() {
    return <<<'JS'
<script>
// Lightbox Modal
function openLightbox(src) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    lightboxImg.src = src;
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Đóng khi click vào backdrop
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        lightbox.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
    }
    
    // Đóng khi nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
});
</script>
JS;
}