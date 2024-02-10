<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Database connection details
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

// Display welcome message with username
$welcome_message = "Welcome, " . $_SESSION['user_name'];

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit();
}

// Update additional details logic
$update_message = ""; // Initialize to empty string
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_details'])) {
    // Validate and process the updated details
    $user_id = $_SESSION['user_id'];
    $age = $conn->real_escape_string($_POST['age']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $mobile_number = $conn->real_escape_string($_POST['mobile_number']);

    // Additional validation and database update
    $sql = "UPDATE users SET age='$age', gender='$gender', dob='$dob', mobile_number='$mobile_number' WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $update_message = "Details updated successfully:<br>
                           Age: $age<br>
                           Gender: $gender<br>
                           Date of Birth: $dob<br>
                           Mobile Number: $mobile_number";
    } else {
        $update_message = "Error updating details: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logout-btn, .update-btn {
            background-color: #ff6347; /* Red color */
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            text-align: left;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 16px;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <p><?php echo $welcome_message; ?></p>
        
        <!-- Logout button -->
        <form method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>

        <!-- Update additional details form -->
        <form method="post" id="updateDetailsForm" onsubmit="return validateForm()">
            <h3>Update Additional Details</h3>
            
            <!-- Display error message if any -->
            <p class="error-message" id="errorMessage"></p>
            
            <!-- Additional details fields -->
            <label for="age">Age:</label>
            <input type="text" id="age" name="age">

            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender">

            <label for="dob">Date of Birth:</label>
            <input type="text" id="dob" name="dob">

            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number">

            <button type="submit" name="update_details" class="update-btn">Update Details</button>
        </form>

        <!-- Display update message -->
        <?php if (!empty($update_message)) { echo "<p>$update_message</p>"; } ?>

        <!-- Add additional profile information or actions here -->
    </div>

    <script>
        function validateForm() {
            // Get form values
            var age = document.getElementById("age").value;
            var gender = document.getElementById("gender").value;
            var dob = document.getElementById("dob").value;
            var mobileNumber = document.getElementById("mobile_number").value;
            
            // Validation logic
            if (!age || isNaN(age) || age <= 0) {
                document.getElementById("errorMessage").innerText = "Please enter a valid age.";
                return false;
            }

            // Add additional validation rules as needed
            
            return true;
        }
    </script>

</body>
</html>
