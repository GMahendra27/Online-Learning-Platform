<?php
session_start();
include 'db.php'; // Ensure this file contains the database connection logic

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to enroll in a course.'); window.location.href = 'login.php';</script>";
    exit();
}

// Fetch available courses from the database
$sql_courses = "SELECT course_id, course_name FROM courses";
$result_courses = $conn->query($sql_courses);

if (!$result_courses) {
    echo "Error fetching courses: " . $conn->error;
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user_id from session
    $user_id = $_SESSION['user_id'];
    
    // Get course_id from form
    $course_id = $_POST['course_id']; // Assuming course_id is passed via POST from course selection
    
    // Insert into enrollments table
    $sql_enroll = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_enroll);
    $stmt->bind_param("ii", $user_id, $course_id); // Assuming both user_id and course_id are integers
    
    if ($stmt->execute()) {
        // Enrollment successful
        echo "<script>alert('Enrollment successful.'); window.location.href = 'my_courses.php';</script>";
        exit();
    } else {
        // Error handling
        echo "<script>alert('Error enrolling in course.'); window.location.href = 'enroll_course.php';</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Course</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Enroll in a Course</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="course_id">Select Course:</label>
                <select id="course_id" name="course_id" class="form-control" required>
                    <?php
                    // Populate the dropdown with options from the courses table
                    while ($row = $result_courses->fetch_assoc()) {
                        echo '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enroll</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
