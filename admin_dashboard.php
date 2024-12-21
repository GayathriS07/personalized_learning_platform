<?php
session_start();
include('db.php');

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Delete user (if requested)
if (isset($_GET['delete_user_id']) && isset($_GET['user_type'])) {
    $user_id = $_GET['delete_user_id'];
    $user_type = $_GET['user_type'];

    if ($user_type === 'student') {
        $delete_query = $conn->prepare("DELETE FROM students WHERE id = ?");
    } elseif ($user_type === 'teacher') {
        $delete_query = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    }

    $delete_query->bind_param("i", $user_id);
    $delete_query->execute();
    $delete_query->close();
}

// Fetch all students and teachers
$students_result = $conn->query("SELECT * FROM students");
$teachers_result = $conn->query("SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, Admin!</h2>
        <h3>Registered Students</h3>
        <table border="1">
            <tr>
                <th>SNo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            $sno = 1;
            while ($student = $students_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$sno}</td>";
                echo "<td>{$student['name']}</td>";
                echo "<td>{$student['email']}</td>";
                echo "<td><a href='admin_dashboard.php?delete_user_id={$student['id']}&user_type=student' class='button delete'>Delete</a></td>";
                echo "</tr>";
                $sno++;
            }
            ?>
        </table>

        <h3>Registered Teachers</h3>
        <table border="1">
            <tr>
                <th>SNo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            $sno = 1;
            while ($teacher = $teachers_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$sno}</td>";
                echo "<td>{$teacher['name']}</td>";
                echo "<td>{$teacher['email']}</td>";
                echo "<td><a href='admin_dashboard.php?delete_user_id={$teacher['id']}&user_type=teacher' class='button delete'>Delete</a></td>";
                echo "</tr>";
                $sno++;
            }
            ?>
        </table>
    </div>
      <!-- Add the Home Button in the footer -->
      <div class="footer">
        <a href="index.php" class="button">Home</a> <!-- This button will redirect to the home page -->
    </div>
</body>
</html>
