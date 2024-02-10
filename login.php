<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Login process
    if (isset($_POST['login'])) {
        $login_email = $_POST['login_email'];
        $login_password = $_POST['login_password'];

        // Fetch user data from the database based on the entered email
        $sql = "SELECT * FROM users WHERE email = '$login_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify the entered password with the hashed password from the database
            if (password_verify($login_password, $row['password'])) {
                // Start the session
                session_start();

                // Store user data in the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];

                // Redirect to the profile page
                header("Location: profile.php");
                exit();
            } else {
                echo "<p>Incorrect password</p>";
            }
        } else {
            echo "<p>User not found</p>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="loginForm">
            <!-- Login form fields -->
            <label for="login_email">Email:</label>
            <input type="email" id="login_email" name="login_email" required>

            <label for="login_password">Password:</label>
            <input type="password" id="login_password" name="login_password" required>

            <button type="submit" name="login">Log In</button>
        </form>
    </div>

    <!-- Your JavaScript validation code here -->

</body>
</html>
