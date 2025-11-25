<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';
session_start();

// Kiểm tra xem đã validate username chưa
if (!isset($_SESSION['temp_username']) || !isset($_SESSION['temp_user_id'])) {
    $_SESSION['loginMessage'] = "Please login first to reset password";
    header("Location: username_login.php");
    exit;
}

$user_id = $_SESSION['temp_user_id'];
$username = $_SESSION['temp_username'];

$user = get_user_by_id($pdo, $user_id);
if (!$user) {
    $_SESSION['loginMessage'] = "User not found";
    header("Location: username_login.php");
    exit;
}

$message = $_SESSION['resetMessage'] ?? '';
$messageType = $_SESSION['resetMessageType'] ?? '';
unset($_SESSION['resetMessage'], $_SESSION['resetMessageType']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <main class="body_deg">
            <div class="form_deg auto-height">
                <div class="title_deg reset-password">
                    <img src="../images/icon.jpg" alt="Logo">
                </div>
                
                <!-- ĐÃ SỬA: Thêm action="submit_forget.php" -->
                <form action="submit_forget.php" method="POST" class="login_form">
                    <h4>Create New Password</h4>
                    
                    <?php if ($message): ?>
                        <div class="message <?php echo $messageType; ?>">
                            <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <label class="label_deg">New Password <span style="color: #dc3545;">*</span></label>
                        <input type="password" name="new_password" required autofocus minlength="6">
                    </div>
                    
                    <div>
                        <label class="label_deg">Confirm Password <span style="color: #dc3545;">*</span></label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                    
                    <div>
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </div>
                    <div class="back-link">
                        <a href="password_login.php"><= Back</a>
                    </div>        
                </form>
            </div>
        </main>
        <footer class="footer_login">
            &copy; web programming 
        </footer>
    </body>
</html>