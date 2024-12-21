<?php
$servername = "localhost";  // Hostname (usually localhost)
$username = "root";         // Username (default is 'root' in XAMPP)
$password = "";             // Password (default is empty for XAMPP)
$dbname = "learning_platform";  // Database name (this should match the name of your database)

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
