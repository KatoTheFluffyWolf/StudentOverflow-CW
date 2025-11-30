<?php include 'nav-bar.php'; ?>
<?php include 'config.php'; ?>
<?php
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $content = htmlspecialchars($_POST["message"]);
    $email = $_SESSION['email'];
    $adminEmail = "anhndgcc240003@gmail.com"; // Admin email address

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $email;     
        $mail->Password   = 'lrob mejr pyhw pzoq';         
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('anhndgcc240003@gmail.com', $name);
        $mail->addAddress($adminEmail);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->send();
        $message = 'Message sent!';
    } catch (Exception $e) {
        $message = "Error: {$mail->ErrorInfo}";
    }
}
?>
<?php include 'templates/contact.html.php'; ?>