<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user email from session
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelPath</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="script.js" defer ></script>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <!-- Add your logo here -->
        </div>
        <button id="logoutBtn">Log Out</button>
    </div>

    <!-- Main content of the page -->
    <div class="hero-section">
        <h1>Welcome to PixelPath</h1>
        <p>You are logged in as: <strong><?php echo htmlspecialchars($email); ?></strong></p>

        <!-- The rest of your main page content -->
        <div class="display">Inspire your feed. Discover your style.</div>
        
        <div class="search-box">
            <input type="text" placeholder="What inspires you today?" id="search">
            <i class="fa-solid fa-magnifying-glass"></i> 
        </div>
    </div>

    <section class="gallery">
        <ul class="images"> </ul>
        <button class="loader">Load More</button>
    </section>

    <script>
        // Log out functionality
        document.getElementById("logoutBtn").addEventListener("click", function() {
            window.location.href = "logout.php"; // This will redirect to the logout script
        });
    </script>
</body>
</html>

