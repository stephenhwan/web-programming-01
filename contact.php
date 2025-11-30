<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require __DIR__ . '/loginPortal/auth.php';


if (isset($_SESSION['send_welcome_email']) && $_SESSION['send_welcome_email'] === true) {
    $username = $_SESSION['new_user_username'];
    $user_password = $_SESSION['new_user_password'];
    $email = $_SESSION['new_user_email'];
    
    // Xóa session để tránh gửi lại
    unset($_SESSION['send_welcome_email']);
    unset($_SESSION['new_user_username']);
    unset($_SESSION['new_user_password']);
    unset($_SESSION['new_user_email']);
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'stephenolivia040303@gmail.com';
        $mail->Password = 'rptb ebmh heqn owhj'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        
        // Recipients
        $mail->setFrom('stephenolivia040303@gmail.com', 'Website Registration');
        $mail->addAddress($email);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Chào mừng bạn đến với hệ thống!';
        $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
                    .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                    .info-box { background-color: #e8f5e9; padding: 15px; margin: 15px 0; border-left: 4px solid #4CAF50; }
                    .footer { text-align: center; padding: 10px; font-size: 12px; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>🎉 Đăng ký thành công!</h1>
                    </div>
                    <div class='content'>
                        <h2>Xin chào {$username},</h2>
                        <p>Cảm ơn bạn đã đăng ký tài khoản!</p>
                        
                        <div class='info-box'>
                            <h3>Thông tin đăng nhập của bạn:</h3>
                            <p><strong>Username:</strong> {$username}</p>
                            <p><strong>Password:</strong> {$user_password}</p>
                            <p><strong>Email:</strong> {$email}</p>
                        </div>
                        
                        <p><strong style='color: #d32f2f;'>⚠️ Lưu ý:</strong> Vui lòng đổi mật khẩu sau khi đăng nhập lần đầu.</p>
                        
                        <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; " . date('Y') . " Web Programming</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        
        $mail->send();
        
        $_SESSION['loginMessage'] = '✅ Đăng ký thành công! Email thông tin tài khoản đã được gửi đến ' . $email;
        $_SESSION['loginMessageType'] = 'success';
        
    } catch (Exception $e) {
        $_SESSION['loginMessage'] = '✅ Đăng ký thành công nhưng không thể gửi email. Lỗi: ' . $mail->ErrorInfo;
        $_SESSION['loginMessageType'] = 'warning';
    }
    
    // Chuyển về trang login
    header('Location: loginPortal/username_login.php');
    exit();
}



check_login();
if(isset($_POST['submit'])) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'stephenolivia040303@gmail.com';
        $mail->Password = 'rptb ebmh heqn owhj'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';
        
        // Recipients
        $mail->setFrom('stephenolivia040303@gmail.com');
        $mail->addAddress($_POST['email']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body = $_POST['message'];
        
        $mail->send();
        echo "<script>
            alert('Message Sent Successfully');
            window.location.href='contact.php';
        </script>";
        
    } catch (Exception $e) {
        echo "<script>
            alert('Message could not be sent. Error: {$mail->ErrorInfo}');
        </script>";
    }
}

ob_start();
include __DIR__ . '/templates/contact.html.php';
$output = ob_get_clean();

include_layout();
?>