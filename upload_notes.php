<?php
include 'db.php';
session_start();

// Ensure that the teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");  // Redirect to login if not authenticated
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $subject = $_POST['subject'];
    $teacher_name = $_SESSION['name'];  // Teacher name from session
    $file = $_FILES['file'];

    // Check if file was uploaded
    if ($file['error'] == 0) {
        // Get the file name and store it in the uploads directory
        $file_name = basename($file['name']);
        $file_path = 'uploads/' . $file_name;

        // Move the file to the uploads directory
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Insert the note details into the database
            $sql = "INSERT INTO notes (subject, teacher_name, file_name, file_path) 
                    VALUES ('$subject', '$teacher_name', '$file_name', '$file_path')";

            if ($conn->query($sql)) {
                echo "Note uploaded successfully!";
            } else {
                echo "Error uploading note: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Notes</title>
</head>
<body>
    <h2>Upload Notes</h2>
    <form action="upload_notes.php" method="POST" enctype="multipart/form-data">
        <label for="subject">Subject:</label>
        <select name="subject" required>
            <option value="Maths">Maths</option>
            <option value="Science">Science</option>
            <option value="Social">Social</option>
            <option value="Kannada">Kannada</option>
            <option value="Hindi">Hindi</option>
            <option value="English">English</option>
        </select><br><br>

        <label for="file">Choose File:</label>
        <input type="file" name="file" required><br><br>

        <button type="submit">Upload</button>
    </form>
</body>
</html>
