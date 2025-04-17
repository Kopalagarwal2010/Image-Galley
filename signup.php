<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Sign Up</h2>
    <form action="signup.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit" name="sign_up">Sign Up</button>
    </form>

    <?php
    // signup.php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $con = mysqli_connect("localhost", "root", "", "user_auth");

        if (!$con) {
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password != $confirm_password) {
            echo "Passwords do not match.";
        } else {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "An account with this email already exists.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $query = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sss", $email, $username, $hashed_password);

                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $con->insert_id;
                    $_SESSION['email'] = $email;

                    // Redirect to main page after sign-up
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            }

            $stmt->close();
        }

        mysqli_close($con);
    }
    ?>
</body>
</html>
