<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require __DIR__ . '/loginPortal/auth.php';
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