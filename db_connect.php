<?php
$servername = "127.0.0.1:3307";
$username = "Mahendra"; // Replace with your username
$password = "root"; // Replace with your password
$dbname = "onlinelearning"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
