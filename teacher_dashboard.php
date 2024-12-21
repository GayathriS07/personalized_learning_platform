<?php
include 'db.php';
session_start();

// Redirect to login page if the teacher is not logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit;
}

$message = "";

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $subject = $_POST['subject'];
    $teacher_name = $_SESSION['name'];
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_path = "uploads/" . $file_name;

    // Move uploaded file to the uploads directory and save details in the database
    if (move_uploaded_file($file_tmp, $file_path)) {
        $conn->query("INSERT INTO notes (subject, teacher_name, file_name) VALUES ('$subject', '$teacher_name', '$file_name')");
        $message = "File uploaded successfully!";
    } else {
        $message = "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
    <title>Teacher Dashboard</title>
    <style>
        /* Inline styles for additional customization */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Light background */
            margin: 0;
            padding: 0;
        }

        .dashboard {
            max-width: 600px;
            margin: 50px auto; /* Center the container */
            padding: 30px;
            background: #fff; /* White background */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2, h3 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        select, input[type="file"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            color: green;
            margin-top: 20px;
        }

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
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
        <h3>Upload Notes</h3>

        <!-- Upload Form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="subject">Select Subject:</label>
            <select name="subject" id="subject" required>
                <option value="Maths">Maths</option>
                <option value="Science">Science</option>
                <option value="Social">Social</option>
                <option value="Kannada">Kannada</option>
                <option value="Hindi">Hindi</option>
                <option value="English">English</option>
            </select>

            <label for="file">Choose File:</label>
            <input type="file" name="file" id="file" required>

            <button type="submit">Upload</button>
        </form>

        <!-- Display success/error message -->
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    </div>

    <!-- Footer with Home Button -->
    <div class="footer">
        <a href="index.php" class="button">Home</a>
    </div>
</body>
</html>
