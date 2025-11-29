<?php
require __DIR__ . '/../includes/DatabaseConnection.php';
require __DIR__ . '/../includes/DatabaseFunction.php';
session_start();

$username = $_SESSION['temp_username'];

$message = $_SESSION['loginMessage'] ?? '';           
$messageType = $_SESSION['loginMessageType'] ?? 'error';  

unset($_SESSION['loginMessage'], $_SESSION['loginMessageType']);
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

                <form action="submit_forget.php" method="POST" class="login_form">
                    <h4>Create New Password</h4>
                    
                    <p style="margin: 0; color: #0c5460;">
                        <span style="font-size: 18px; color: #004085;">Account: <?= htmlspecialchars($username) ?></span>
                    </p>
                    
                    <div>
                        <label class="label_deg">New Password <span style="color: #dc3545;">*</span></label>
                        <input type="password" name="new_password" required autofocus minlength="8">
                        <p class="password-requirements">At least 8 characters</p>
                    </div>
                    
                    <div>
                        <label class="label_deg">Confirm Password <span style="color: #dc3545;">*</span></label>
                        <input type="password" name="confirm_password" required minlength="8">
                    </div>
                    
                    <div>
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </div>
                    <div class="back-link">
                        <a href="password_login.php">← Back</a>
                    </div>
                    <div class="message-container">
                        
                        <?php if ($message): ?>
                            <div class="message <?= htmlspecialchars($messageType) ?>">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>
                    </div>    
                </form>
            </div>
        </main>
        <footer class="footer_login">
            &copy; web programming 
        </footer>
    </body>
</html>