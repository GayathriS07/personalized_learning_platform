<?php
session_start();

// Define fixed admin credentials
define('ADMIN_USERNAME', 'admin');  // Replace 'admin' with your preferred username
define('ADMIN_PASSWORD', 'admin@123');  // Replace 'admin123' with your preferred password

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered credentials match the fixed credentials
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_id'] = 1;  // Fixed admin ID (can be any number)
        $_SESSION['username'] = $username;  // Store admin username in session
        header("Location: admin_dashboard.php");  // Redirect to admin dashboard
        exit();
    } else {
        $message = "Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin Login</title>
    <style> 
    .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .footer .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Login</h2>
        <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>
        <form method="POST" action="admin_login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Enter your username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="button">Login</button>
        </form>
    </div>
      <!-- Add the Home Button in the footer -->
      <div class="footer">
        <a href="index.php" class="button">Home</a> <!-- This button will redirect to the home page -->
    </div>
</body>
</html>
