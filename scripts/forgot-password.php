<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include the PHPMailer library

// Initialize PHPMailer
$mail = new PHPMailer(true);

// SMTP Configuration
$mail->isSMTP();
$mail->Host = 'smtp.example.com'; // Your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'your_username';
$mail->Password = 'your_password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// Sender and recipient details
$mail->setFrom('dnacd123@gmail.com', 'Cedrick Dangcalan');
$mail->addAddress($_POST['email']); // Add the user's email address

// Email content
$mail->isHTML(true);
$mail->Subject = 'Password Reset';
$mail->Body = 'Click the following link to reset your password: <a href="https://example.com/reset-password.php">Reset Password</a>';

// Send the email
if ($mail->send()) {
    echo 'Email sent successfully.';
} else {
    echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
?>
