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
                    <h4>
                        <?php
                        error_reporting(0);
                        session_start();
                        $message = $_SESSION['loginMessage'] ?? '';
                        unset($_SESSION['loginMessage']);
                        echo $message;
                        ?>
                    </h4>
                </div>
                <form action="validate_username.php" method="POST" class="login_form">
        
                    <div>
                        <label class="label_deg">Username</label>
                        <input type="text" name="username" required autofocus 
                               value="<?php echo htmlspecialchars($_SESSION['temp_username'] ?? '', ENT_QUOTES); ?>">
                    </div>
                    <div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                    </div>
                    <div class ="sign-up-link">
                        <a href ="register_user.php">Sign up for free</a> 
                    </div>
                </form>
            </div>
        </main>
        <footer class="footer_login">
            &copy; web programming
        </footer>
    </body>
</html>