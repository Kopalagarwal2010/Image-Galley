<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
</head>
<body>


    <h2>Signup Form</h2>
    <form action="form.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit" name="sign_up">Sign Up</button>
    </form>

</body>
</html>



<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "user_auth");

// Check connection
if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if (isset($_POST['sign_up'])) {
    // Retrieve form data
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form inputs
    if (empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
        exit();
    }

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert query
    $insertQuery = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
    $stmt = $con->prepare($insertQuery);

    if ($stmt) {
        $stmt->bind_param("sss", $email, $username, $hashed_password);

        // Execute the query
        if ($stmt->execute()) {
            echo "Signup successful! <a href='login.html'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare the statement: " . $con->error;
    }
}

// Close the connection
mysqli_close($con);
?>
