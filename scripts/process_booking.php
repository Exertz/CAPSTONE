<?php

include '../env.php';

// Create a database connection
$conn = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD, $DATABASE_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionType = $_POST["SessionCategory"];
    $sessionDate = $_POST["SessionDate"];
    $serviceSelection = isset($_POST['ServiceSelection']) ? $_POST['ServiceSelection'] : ''; // Check if it's set
    $streetAddress = $_POST['StreetAddress'];
    $city = $_POST['City'];
    $paymentMethod = $_POST['PaymentMethod'];

    if (isset($_POST['SessionDate'])) {
        $sessionDate = $_POST['SessionDate'];
        // Now you can use $sessionDate in your script.
    } else {
        // Handle the case where the "SessionDate" field is not set in the form.
        // You can display an error message or take other appropriate actions.
    }
    
    // Check if $serviceSelection is not empty
    if (!empty($serviceSelection)) {
        // Insert data into the database
        $sql = "INSERT INTO booking (session_type, session_date, service_selection, street_address, city, payment_method)
                VALUES ('$sessionType', '$sessionDate', '$serviceSelection', '$streetAddress', '$city', '$paymentMethod')";

        if ($conn->query($sql) === TRUE) {
            echo "Booking submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Service selection is required.";
    }
}

// Close the database connection
$conn->close();
?>