<?php
$servername = "localhost";
$username = "root";
$password = "Aakash@01";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connecting successfully!";

// Validation and Redirect
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a form field named 'validation_field'
    $validationField = $_POST["validation_field"];

    // Perform your validation here, for example:
    if (empty($validationField)) {
        die("Validation failed. Please fill in all required fields.");
    }

    // If validation passes, redirect to Register.php
    header("Location: signup.php");
    exit();
}

// Close the database connection
$conn->close();
?>
