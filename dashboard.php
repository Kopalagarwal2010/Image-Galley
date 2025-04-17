<?php
session_start();

// Check if the user is logged in by checking the session variable
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

// Database connection
$con = mysqli_connect("localhost", "root", "", "user_auth");

if (!$con) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Fetch user data from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
mysqli_close($con);

// Display the user profile
echo "<h1>Welcome, " . htmlspecialchars($user['username']) . "</h1>";
echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
echo "<p>Account created on: " . $user['created_at'] . "</p>";

// Add additional profile content here (e.g., user-specific posts, gallery, etc.)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <!-- Add your logo here -->
        </div>
        <button id="logoutBtn">Log Out</button>
    </div>

    <div class="user-profile">
        <!-- You can add more content to the user's profile page here -->
        <h2>Your Profile</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Account created on:</strong> <?php echo $user['created_at']; ?></p>

        <!-- Optionally add a button to edit profile, view user posts, etc. -->
    </div>

    <div class="footer">
        <!-- Footer content -->
        <p>&copy; 2024 PixelPath</p>
    </div>

    <script>
        // Log out functionality
        document.getElementById("logoutBtn").addEventListener("click", function() {
            window.location.href = "logout.php"; // This will redirect to the logout script
        });
    </script>
</body>
</html>
