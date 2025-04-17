<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Log In</button>
    </form>

    <?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "user_auth");

if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Both email and password are required.";
    } else {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Start session and store user data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email']; // Store email in session

                // Immediately redirect to index.php
                header("Location: index.php"); 
                exit(); // Ensure no further code is executed after redirect
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with this email.";
        }

        $stmt->close();
    }
}

mysqli_close($con);
?>


    ?>
</body>
</html>
