<?php
$servername = "127.0.0.1:3307";
$username = "Mahendra";
$password = "root";
$dbname = "onlinelearning";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
