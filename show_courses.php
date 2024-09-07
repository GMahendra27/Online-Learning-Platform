<?php
session_start();

$server = "127.0.0.1:3307";
$username = "Mahendra";
$password = "root";
$database = "onlinelearning";
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    exit('Connection failed: ' . mysqli_connect_error());
}

// Fetch all courses
$qry = "SELECT * FROM courses";
$res = mysqli_query($conn, $qry);
if (!$res) {
    exit('Error fetching courses: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">All Courses</h2>
    <?php
    if (mysqli_num_rows($res) > 0) {
        while ($course = mysqli_fetch_assoc($res)) {
            echo '<div class="card mb-4">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $course['course_name'] . ' (ID: ' . $course['course_id'] . ')</h5>';
            echo '<p class="card-text"><strong>Duration:</strong> ' . $course['duration'] . '</p>';
            echo '<p class="card-text"><strong>Description:</strong> ' . $course['description'] . '</p>';

            // Display Videos
            echo '<p class="card-text"><strong>Videos:</strong><br>';
            $videos = explode("\n", $course['videos']);
            foreach ($videos as $video) {
                echo '<a href="' . htmlspecialchars($video) . '" target="_blank">' . htmlspecialchars($video) . '</a><br>';
            }
            echo '</p>';

            // Display Assignments
            echo '<p class="card-text"><strong>Assignments:</strong><br>';
            $course_id = $course['course_id'];
            $qry_assignments = "SELECT * FROM assignments WHERE course_id = $course_id";
            $res_assignments = mysqli_query($conn, $qry_assignments);

            if (!$res_assignments) {
                echo 'Error fetching assignments: ' . mysqli_error($conn);
            } else {
                if (mysqli_num_rows($res_assignments) > 0) {
                    while ($assignment = mysqli_fetch_assoc($res_assignments)) {
                        echo '<a href="assignment.php?id=' . htmlspecialchars($assignment['id']) . '">' . htmlspecialchars($assignment['title']) . '</a><br>';
                    }
                } else {
                    echo 'No assignments found for this course.';
                }
            }

            echo '</p>';

            echo '<p class="card-text"><strong>Cost:</strong> ' . htmlspecialchars($course['cost']) . '</p>';
            echo '<p class="card-text"><strong>Status:</strong> ' . ucfirst(htmlspecialchars($course['status'])) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No courses found.</p>';
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
