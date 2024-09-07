<?php
session_start();
include_once 'db_connect.php'; // Adjust this according to your file structure

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to view your assignments.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve enrolled courses and their assignments for the user
$sql = "SELECT c.course_id, c.course_name, a.id as assignment_id, a.title as assignment_title
        FROM courses c
        INNER JOIN enrollments e ON c.course_id = e.course_id
        LEFT JOIN assignments a ON c.course_id = a.course_id
        WHERE e.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[$row['course_id']]['course_name'] = $row['course_name'];
    if (!empty($row['assignment_id'])) {
        $courses[$row['course_id']]['assignments'][] = [
            'assignment_id' => $row['assignment_id'],
            'assignment_title' => $row['assignment_title']
        ];
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Assignments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Your Assignments</h2>
    <?php
    if (!empty($courses)) {
        foreach ($courses as $course_id => $course) {
            echo '<div class="card mb-4">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($course['course_name']) . '</h5>';

            // Display Assignments
            echo '<p class="card-text"><strong>Assignments:</strong><br>';
            if (!empty($course['assignments'])) {
                foreach ($course['assignments'] as $assignment) {
                    echo '<a href="assignment.php?id=' . htmlspecialchars($assignment['assignment_id']) . '">' . htmlspecialchars($assignment['assignment_title']) . '</a><br>';
                }
            } else {
                echo 'No assignments found for this course.';
            }
            echo '</p>';

            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>You are not enrolled in any courses or no assignments found for your courses.</p>';
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
