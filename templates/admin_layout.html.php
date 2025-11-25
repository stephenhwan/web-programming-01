<?php 
if (!isset($_SESSION['username'])) {
    header("Location: loginPortal/login.php");
    exit;
}
elseif($_SESSION['user_type'] != "admin"){
    header("Location: loginPortal/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Web Programming 1</title>
</head>
<body>  
    <header>

        <a href="loginPortal/logout.php" class="account"            
    style="color: white; text-decoration: none; float: right; padding: 10px;">
    <img src="images/profile.png" class="icon-account" alt="Profile">
    Logout (<?= htmlspecialchars($_SESSION['username']) ?>)
        </a>
        <h1>WEB PROGRAMMING 2</h1>
        <!-- ✅ FIXED: Dùng đường dẫn tương đối -->

    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="forum.php">Student Forum</a></li>
            <li><a href="addquestion.php">Add a question</a></li>
            <li><a href="user.php">User</a></li>
            <li><a href="module.php">Modules</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </nav>
    
    <main>
        <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <?= $output ?? '' ?>
    </main>
    
    <footer>&copy; Stephenhwan2025</footer>
</body>
</html>