<?php
session_start();
$message = $_SESSION['loginMessage'] ?? '';           
$messageType = $_SESSION['loginMessageType'] ?? 'error';  
$temp_username = $_SESSION['new_user_username'] ?? '';
unset($_SESSION['loginMessage'], $_SESSION['loginMessageType']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - Enter Username</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <main class="body_deg">
            <div class="form_deg auto-height">
                <div class="title_deg">
                    <img src="../images/icon.jpg" alt="Logo">
                </div>
                <form action="process_terms.php" method="POST" class="login_form">
                    <div>
                        <div class="terms-content">
                            <p class="user-name">Hello <strong><?php echo htmlspecialchars($temp_username); ?></strong>,</p>
                            <p>We will send a account to your email.</p>
                        </div>
                    
                                </div>
                                <div class="checkbox-container">
                                    <input type="checkbox" 
                                        name="agree_marketing" 
                                        id="agree_marketing">
                                    <label for="agree_terms">
                                        Please dont't send marketing email to me
                                    </label>
                                </div>
                                
                                <div class="submit-container">
                                    <div class="back-link-term">
                                        <a href="register_user.php"><= Back</a>
                                    </div>     
                                    <button type="submit"
                                            class="btn btn-primary"  
                                            name="submit" 
                                            value="submit"
                                            required autofocus>
                                        Send
                                    </button>
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

