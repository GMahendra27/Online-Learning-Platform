<?php
session_start();
include_once 'db_connect.php'; // Adjust this according to your file structure

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to view your courses.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve enrolled courses for the user
$sql = "SELECT c.course_id, c.course_name, c.videos, c.description
        FROM courses c
        INNER JOIN enrollments e ON c.course_id = e.course_id
        WHERE e.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<div class='container mt-5'>";
    echo "<h2>Your Enrolled Courses:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card mb-4">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['course_name']) . '</h5>';
        echo '<p class="card-text"><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';

        // Display Videos
        echo '<p class="card-text"><strong>Videos:</strong><br>';
        $videos = explode("\n", $row['videos']);
        foreach ($videos as $video) {
            echo '<a href="' . htmlspecialchars($video) . '" target="_blank">' . htmlspecialchars($video) . '</a><br>';
        }
        echo '</p>';

        // Display Assignments
        echo '<p class="card-text"><strong>Assignments:</strong><br>';
        $course_id = $row['course_id'];
        $qry_assignments = "SELECT * FROM assignments WHERE course_id = ?";
        $stmt_assignments = $conn->prepare($qry_assignments);
        $stmt_assignments->bind_param("i", $course_id);
        $stmt_assignments->execute();
        $res_assignments = $stmt_assignments->get_result();

        if ($res_assignments->num_rows > 0) {
            while ($assignment = $res_assignments->fetch_assoc()) {
                echo '<a href="assignment.php?id=' . htmlspecialchars($assignment['id']) . '">' . htmlspecialchars($assignment['title']) . '</a><br>';
            }
        } else {
            echo 'No assignments found for this course.';
        }

        $stmt_assignments->close();
        echo '</p>';

        echo '</div>';
        echo '</div>';
    }
    echo "</div>";
} else {
    echo "<p>You are not enrolled in any courses yet.</p>";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Courses</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
</body>
</html>
