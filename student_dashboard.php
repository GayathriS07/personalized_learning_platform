<?php
include 'db.php';
session_start();

// Ensure that the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");  // Redirect to login if not authenticated
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch subjects with available notes
$sql = "SELECT DISTINCT subject FROM notes"; // Get unique subjects
$subject_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .dashboard {
            max-width: 900px;
            margin: 0 auto;
        }

        .subject-container {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .subject-heading {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
            text-align: left; /* Aligns heading with table */
            padding-left: 10px;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }

        .notes-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .notes-table th, .notes-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .notes-table th {
            background-color: #007bff;
            color: white;
        }

        .notes-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .notes-table tr:nth-child(odd) {
            background-color: #fff;
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
        <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
        <h3>Available Notes</h3>

        <?php while ($subject_row = $subject_result->fetch_assoc()): ?>
            <div class="subject-container">
                <h4 class="subject-heading"><?php echo $subject_row['subject']; ?> Notes</h4> <!-- Display subject name as heading -->

                <?php
                // For each subject, retrieve the notes
                $subject = $subject_row['subject'];
                $note_sql = "SELECT * FROM notes WHERE subject = '$subject'";
                $note_result = $conn->query($note_sql);

                if ($note_result && $note_result->num_rows > 0): ?>
                    <table class="notes-table">
                        <tr>
                            <th>SNo</th>
                            <th>Note Name</th>
                            <th>Download</th>
                        </tr>
                        <?php $counter = 1; ?>
                        <?php while ($note_row = $note_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $counter++; ?></td>
                                <td><?php echo $note_row['file_name']; ?></td>
                                <td>
                                    <a href="uploads/<?php echo $note_row['file_name']; ?>" class="button" download>Download</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No notes available for <?php echo $subject; ?>.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Add the Home Button in the footer -->
    <div class="footer">
        <a href="index.php" class="button">Home</a> <!-- This button will redirect to the home page -->
    </div>
</body>
</html>

