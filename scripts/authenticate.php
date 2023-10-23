<?php

include '../env.php';
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "pvbdb";

try {
  $conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DATABASE_NAME);
  
  // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// retreive data from form


  $email = $_POST["email"];
  $password = $_POST["password"];

  $passwordHash = md5($password);
  
  $sql = "SELECT * FROM users WHERE `email_address` = '{$email}' AND `password` = '{$passwordHash}' ";
  
  $result = $conn->query($sql);

  $row = $result->fetch_assoc();
  
  if ($row) {
    // User exists, go to the home page
    header("Location: {$APP_URL}./pages/home.html");
} else {
    // User does not exist, go back to the login page
    header("Location: {$APP_URL}/login.html");
    echo 'No user exists';
}

} catch(Exception $e) {
  echo "Query Failed: " . $e->getMessage();
}
?>