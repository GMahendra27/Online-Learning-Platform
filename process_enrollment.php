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
    $course_id = $conn->real_escape_string($_POST["course_id"]);
    $student_name = $conn->real_escape_string($_POST["student_name"]);

    // Example SQL query for insertion into enrollments table
    $sql = "INSERT INTO enrollments (course_id, student_name) VALUES ('$course_id', '$student_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Enrollment successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
