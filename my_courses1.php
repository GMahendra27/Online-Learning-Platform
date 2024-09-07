<?php
session_start(); // Start the session to access session variables

// Check if user is logged in and retrieve user_id from session
if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page if not logged in
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Retrieve user_id from session

// Database connection details
$servername = "127.0.0.1:3333";
$username = "Mahendra";
$password = "root";
$dbname = "onlinelearning";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve enrolled courses for the logged-in user
$sql = "SELECT courses.id, courses.name, courses.duration, courses.description, courses.cost
        FROM enrolled_courses
        INNER JOIN courses ON enrolled_courses.course_id = courses.id
        WHERE enrolled_courses.user_id = $user_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
        echo "<p><strong>Duration:</strong> " . htmlspecialchars($row["duration"]) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";
        echo "<p><strong>Cost:</strong> $" . number_format($row["cost"], 2) . "</p>";
        echo "</div><hr>";
    }
} else {
    echo "<p>No courses enrolled.</p>";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .course-card {
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: #ffffff;
        }
        .course-card h2 {
            font-size: 1.5rem;
        }
        .course-card p {
            margin-bottom: .5rem;
        }
        .course-card ul {
            padding-left: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">My Courses</h1>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='course-card'>";
                echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
                echo "<p><strong>Duration:</strong> " . htmlspecialchars($row["duration"]) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";

                $videos = json_decode($row["videos"], true);
                if (!empty($videos)) {
                    echo "<p><strong>Videos:</strong></p>";
                    echo "<ul>";
                    foreach ($videos as $video) {
                        echo "<li><a href='" . htmlspecialchars($video) . "' target='_blank'>" . htmlspecialchars($video) . "</a></li>";
                    }
                    echo "</ul>";
                }

                $assignments = json_decode($row["assignments"], true);
                if (!empty($assignments)) {
                    echo "<p><strong>Assignments:</strong></p>";
                    echo "<ul>";
                    foreach ($assignments as $assignment) {
                        echo "<li>" . htmlspecialchars($assignment) . "</li>";
                    }
                    echo "</ul>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No enrolled courses available.</p>";
        }

        $conn->close();
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
