<?php

include '../env.php';

// Establish a MySQL database connection (replace with your database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pvbdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process user registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $password = $_POST["password"];

    // Add additional security measures like hashing the password (do not store plain text passwords)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, password)
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: {$APP_URL}/login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>