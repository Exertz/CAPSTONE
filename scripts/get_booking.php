<?php
// Establish a database connection (modify these values)
$servername = "localhost";
$username = "root";
$password = "";
$database = "pvbdb";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve booking data
$sql = "SELECT name, email, date FROM bookings";
$result = $conn->query($sql);

// Create an array to store the booking data
$bookings = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($bookings);
?>