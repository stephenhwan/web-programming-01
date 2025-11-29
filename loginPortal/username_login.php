<?php
session_start();
$message = $_SESSION['loginMessage'] ?? '';           
$messageType = $_SESSION['loginMessageType'] ?? 'error';  

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
                <form action="validate_username.php" method="POST" class="login_form">

                    <div>   
                        <label class="label_deg">Username</label>
                        <input type="text" name="username" required autofocus 
                               value="<?php echo htmlspecialchars($_SESSION['temp_username'] ?? '', ENT_QUOTES); ?>">
                    </div>
                    <div class ="submit-container">
                        <a href="register_user.php">Sign up for free</a>         
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
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

