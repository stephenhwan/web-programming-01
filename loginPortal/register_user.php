<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
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
                <form action="register.php" method="POST" class="login_form">
                    <h4>Register New User</h4>
                    <div>
                        <label class="label_deg">Username</label>
                        <input type="text" name="username" required autofocus> 
                               
                    </div>
                    <div>
                        <label class="label_deg">Password</label>
                        <input type="password" name="user_password" required autofocus >

                        <button type="submit" class="btn-primary" autofocus>Submit</button>
                                     
                    </div>
                                <div class="back-link">
                        <a href="username_login.php"><= Back</a>
                    </div>        
                </form>
            </div>
        </main>
        <footer class="footer_login">
            &copy; web programming
        </footer>
    </body>
</html>