<?php
session_start();

if (!isset($_SESSION['temp_username'])) {
    header("Location: username_login.php");
    exit;
}

$username = $_SESSION['temp_username'];

$message = $_SESSION['loginMessage'] ?? '';
$messageType = $_SESSION['loginMessageType'] ?? 'error';
unset($_SESSION['loginMessage'], $_SESSION['loginMessageType']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - Enter Password</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <main class="body_deg">
            <div class="form_deg auto-height">
                <div class="title_deg">
                    <img src="../images/icon.jpg" alt="Logo">
                </div>
                <form action="validate_password.php" method="POST" class="login_form">
        
                    <div>
                        <label class="label_deg">Password</label>
                        <input type="password" name="password" required autofocus>
                    </div>
                    
                    <div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                    </div>
                    
                    <div class="forgot-password">
                        <a href="forget_password.php">Forgot Password?</a>
                    </div>
                    
                    <div class="back-link">
                        <a href="username_login.php">← Back</a>
                    </div>
                    <div class="message-container">
                        <?php if (!empty($message)): ?>
                            <div class="message <?php echo $messageType === 'success' ? 'success' : 'error'; ?> auto-hide">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>    
                </form>
            </div>
        </main>
        <footer class="footer_login">
            &copy; web programming 
        </footer>
    </body>
</html>