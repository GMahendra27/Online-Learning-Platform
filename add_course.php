<?php
$servername = "127.0.0.1:3307";
$username = "Mahendra";
$password = "root"; // Replace with your actual password
$dbname = "onlinelearning";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    exit('Connection failed: ' . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize POST data
    $name = $conn->real_escape_string($_POST["name"]);
    $duration = $conn->real_escape_string($_POST["duration"]);
    $videos = $conn->real_escape_string($_POST["videos"]);
    $assignments = $conn->real_escape_string($_POST["assignments"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $cost = $conn->real_escape_string($_POST["cost"]);

    // Example SQL query for insertion
    $sql = "INSERT INTO courses (course_name, description, videos, duration, assignments, cost)
            VALUES ('$name', '$description', '$videos', '$duration', '$assignments', '$cost')";

    if ($conn->query($sql) === TRUE) {
        echo "New course created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: No data received from the form.";
}

$conn->close();
?>
