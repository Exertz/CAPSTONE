<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

include '../env.php';

// Establish a MySQL database connection (replace with your database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pvbdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Generate a verification token (you can use a random string)
$verification_token = bin2hex(random_bytes(16)); // Example: 32 characters

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process user registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $email_address = $_POST["email_address"];
    $phone_number = $_POST["phone_number"];
    $password = $_POST["password"];

    // Add additional security measures like hashing the password (do not store plain text passwords)
    $hashed_password = md5($password);

     // Insert user data into the database, including the verification token
     $sql = "INSERT INTO users (full_name, email_address, phone_number, password, verification_token)
     VALUES ('$full_name', '$email_address', '$phone_number', '$hashed_password', '$verification_token')";

if ($conn->query($sql) === TRUE) {
 // Send a verification email
 $mail = new PHPMailer(true);

 try {
     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'cedrickdangcalan515@gmail.com';
     $mail->Password = 'hwgy efyz ebfj ffvz';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;

     $mail->setFrom('cedrickdangcalan515@gmail.com', 'Cedrick Dangcalan');
     $mail->addAddress($email_address, $full_name);

     $mail->isHTML(true);
     $mail->Subject = 'Account Verification';
     $mail->Body = "Please click the following link to verify your email: <a href='{$APP_URL}/verify.php?token=$verification_token'>Verify Email</a>";

     $mail->send();

     header("Location: {$APP_URL}/login.html");
 } catch (Exception $e) {
     echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
 }
} else {
 echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
}
?>