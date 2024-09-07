<?php
$servername = "127.0.0.1:3333";
$username = "Mahendra";
$password = "root"; // Replace with your actual password
$dbname = "onlinelearning";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    exit('Connection failed'.mysqli_connect_error());
}

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses List</title>
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
        <h1 class="mb-4">Courses</h1>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='course-card'>";
                echo "<h2>" . htmlspecialchars($row["name"]) . "</h2>";
                echo "<p><strong>Duration:</strong> " . htmlspecialchars($row["duration"]) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";
                echo "<p><strong>Cost:</strong> $" . htmlspecialchars($row["cost"]) . "</p>";

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

                echo "<form method='post' action='payment.php'>";
                echo "<input type='hidden' name='course_id' value='" . $row["id"] . "'>";
                echo "<input type='hidden' name='course_name' value='" . htmlspecialchars($row["name"]) . "'>";
                echo "<input type='hidden' name='course_cost' value='" . htmlspecialchars($row["cost"]) . "'>";
                echo "<button type='submit' class='btn btn-primary'>Enroll</button>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "<p>No courses available.</p>";
        }

        $conn->close();
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
