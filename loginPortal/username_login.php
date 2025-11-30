<?php
session_start();
$message = $_SESSION['loginMessage'] ?? '';           
$messageType = $_SESSION['loginMessageType'] ?? 'error';  

unset($_SESSION['loginMessage'], $_SESSION['loginMessageType']);
    
if (!isset($_COOKIE['cookie_consent'])): ?>
<div id="cookie-banner" class="cookie-banner">

    <p class="cookie-text">
        We value your privacy, We use cookies to enhance your browsing experience, provide personalized ads or content,
        and analyze our traffic. <br>
        By clicking "Accept all", you agree to our use of cookies.
    </p>

    <div class="cookie-buttons">
        <button class="cookie-btn accept" onclick="acceptCookies()">Accept</button>
        <button class="cookie-btn reject" onclick="acceptCookies()">Reject</button>
        <a href="../templates/termPrivacy.html.php" class="cookie-link">Learn More</a>
    </div>
</div>

<script>
function acceptCookies() {
    document.cookie = "cookie_consent=true; max-age=31536000; path=/";
    document.getElementById('cookie-banner').style.display = 'none';
}
</script>
<?php endif; ?>

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
            <div class ="terms-privacy">
                <a href="../templates/termPrivacy.html.php" target="_blank">Terms of uses</a> 
                <a href="../templates/termPrivacy.html.php" target="_blank">Privacy & cookies</a>

        </footer>
    </body>
</html>

