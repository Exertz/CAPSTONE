<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "pvbdb");
$email = $_POST["email"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$reset_token = time() . md5($email);

	$sql = "UPDATE users SET reset_token='$reset_token' WHERE email='$email'";
	mysqli_query($connection, $sql);

	$message = "<p>Please click the link below to reset your password</p>";
	$message .= "<a href='http://localhost/tutorials/add-a-reset-password-option/reset-password.php?email=$email&reset_token=$reset_token'>";
		$message .= "Reset password";
	$message .= "</a>";

	send_mail($email, "Reset password", $message);
}
else
{
	echo "Email does not exists";
}

function send_mail($to, $subject, $message)
{
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
	    $mail->isSMTP();                                            // Set mailer to use SMTP
	    $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'cedrickdangcalan515@gmail.com';                     // SMTP username
	    $mail->Password   = 'hwgy efyz ebfj ffvz';                               // SMTP password
	    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
	    $mail->Port       = 587;                                    // TCP port to connect to

	    $mail->setFrom('cedrickdangcalan515@gmail.com', 'Cedrick Dangcalan');
	    //Recipients
	    $mail->addAddress($to);

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $subject;
	    $mail->Body    = $message;

	    $mail->send();
	    echo 'Message has been sent';
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
