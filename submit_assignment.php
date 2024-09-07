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

$answers = $_POST['answers'];
$score = 0;
$total_questions = count($answers);

foreach ($answers as $question_id => $option_id) {
    $qry = "SELECT is_correct FROM options WHERE id = '$option_id'";
    $res = mysqli_query($conn, $qry);
    $option = mysqli_fetch_assoc($res);
    if ($option['is_correct']) {
        $score++;
    }
}

$percentage = ($score / $total_questions) * 100;

echo "<script>alert('Your score is: $score out of $total_questions ($percentage%)');</script>";
echo "<script>window.location.href='assignments_list.php';</script>";
?>
