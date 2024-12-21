<?php
session_start();
include('db.php');  // Include your DB connection

// Handle the login process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is a student
    $stmt = $conn->prepare("SELECT * FROM students WHERE name = ? AND email = ? AND password = ?");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $_SESSION['student_id'] = $student['id'];  // Store student ID in session
        $_SESSION['name'] = $student['name'];      // Store student name in session
        header("Location: student_dashboard.php");  // Redirect to student dashboard
        exit();
    } else {
        // Check if the user is a teacher
        $stmt = $conn->prepare("SELECT * FROM teachers WHERE name = ? AND email = ? AND password = ?");
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $teacher = $result->fetch_assoc();
            $_SESSION['teacher_id'] = $teacher['id'];  // Store teacher ID in session
            $_SESSION['name'] = $teacher['name'];      // Store teacher name in session
            header("Location: teacher_dashboard.php");  // Redirect to teacher dashboard
            exit();
        } else {
            $message = "Invalid credentials!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
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
        <h2>Login</h2>
        <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>
        <form method="POST" action="login.php">
            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Enter your name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="button">Login</button>
        </form>
        <p>Don't have an account? <a href="registration.php">Register here</a></p>
    </div>
      <!-- Add the Home Button in the footer -->
      <div class="footer">
        <a href="index.php" class="button">Home</a> <!-- This button will redirect to the home page -->
    </div>
</body>
</html>
