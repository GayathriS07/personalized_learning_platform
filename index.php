<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">  <!-- Link to your updated CSS -->
    <title>Personalized Learning Platform</title>
</head>
<body>
    <!-- Main container for content -->
    <div class="main-container">
        <!-- Title at the top -->
        <div class="index-container">
            <h1>Personalized Learning Platform</h1>
        </div>

        <!-- Buttons for login/registration -->
        <div class="index-buttons">
            <a href="login.php" class="button">Student Login</a>
            <a href="login.php" class="button">Teacher Login</a>
            <a href="registration.php" class="button">Register</a>
            <a href="admin_login.php" class="button">Admin Login</a>
        </div>
    </div>
</body>
</html>
