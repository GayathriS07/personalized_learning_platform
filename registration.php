<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];  // 'student' or 'teacher'
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validation
    if (!empty($name) && !empty($email) && !empty($password)) {
        if ($role == 'student') {
            // Insert into 'students' table
            $stmt = $conn->prepare("INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            $stmt->execute();
            $message = "Student registered successfully!";
        } elseif ($role == 'teacher') {
            $subject = $_POST['subject'];
            // Insert into 'teachers' table
            $stmt = $conn->prepare("INSERT INTO teachers (name, email, password, subject) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password, $subject);
            $stmt->execute();
            $message = "Teacher registered successfully!";
        } else {
            $message = "Invalid role selected!";
        }
    } else {
        $message = "Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Registration</h2>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="POST">
            <label for="role">Role:</label>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Full Name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>

            <div id="teacher-subject" style="display: none;">
                <label for="subject">Subject:</label>
                <select name="subject">
                    <option value="Maths">Maths</option>
                    <option value="Science">Science</option>
                    <option value="Social">Social</option>
                    <option value="Kannada">Kannada</option>
                    <option value="Hindi">Hindi</option>
                    <option value="English">English</option>
                </select>
            </div>

            <button type="submit" class="button">Register</button>
        </form>
    </div>
   <!-- Footer with Home Button -->
   <div class="footer">
        <a href="index.php" class="button">Home</a>
    </div>

    <script>
        const roleSelect = document.querySelector('select[name="role"]');
        const teacherSubjectDiv = document.getElementById('teacher-subject');
        
        roleSelect.addEventListener('change', function() {
            if (this.value === 'teacher') {
                teacherSubjectDiv.style.display = 'block';
            } else {
                teacherSubjectDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>
