<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to add an assignment.'); window.location.href='login.php';</script>";
    exit();
}

$server = "127.0.0.1:3307";
$username = "Mahendra";
$password = "root";
$database = "onlinelearning";
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    exit('Connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['add_assignment'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $videos = $_POST['videos']; // Assuming videos are provided as newline-separated URLs
    $created_by = $_SESSION['user_id']; // Assuming the user is logged in and user ID is stored in the session

    // Check if the user_id exists in the users table
    $qry_user_check = "SELECT user_id FROM users WHERE user_id = '$created_by'";
    $res_user_check = mysqli_query($conn, $qry_user_check);
    if (mysqli_num_rows($res_user_check) > 0) {
        // Insert assignment into assignments table
        $qry = "INSERT INTO assignments (course_id, title, description, created_by, videos) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $qry);
        mysqli_stmt_bind_param($stmt, "issss", $course_id, $title, $description, $created_by, $videos);

        if (mysqli_stmt_execute($stmt)) {
            $assignment_id = mysqli_insert_id($conn);

            // Insert questions and options into questions and options tables
            foreach ($_POST['questions'] as $index => $question_text) {
                $qry_question = "INSERT INTO questions (assignment_id, question_text) VALUES (?, ?)";
                $stmt_question = mysqli_prepare($conn, $qry_question);
                mysqli_stmt_bind_param($stmt_question, "is", $assignment_id, $question_text);

                if (mysqli_stmt_execute($stmt_question)) {
                    $question_id = mysqli_insert_id($conn);

                    foreach ($_POST['options'][$index] as $option_index => $option_text) {
                        $is_correct = $_POST['correct_option'][$index] == $option_index ? 1 : 0;
                        $qry_option = "INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)";
                        $stmt_option = mysqli_prepare($conn, $qry_option);
                        mysqli_stmt_bind_param($stmt_option, "isi", $question_id, $option_text, $is_correct);
                        mysqli_stmt_execute($stmt_option);
                    }
                } else {
                    echo "<script>alert('Failed to add question');</script>";
                }
            }

            echo "<script>alert('Assignment added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add assignment');</script>";
        }
    } else {
        echo "<script>alert('Invalid user');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assignment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add Assignment</h2>
        <form method="post">
            <div class="form-group">
                <label for="course_id">Course ID</label>
                <input type="number" class="form-control" id="course_id" name="course_id" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="videos">Videos (One URL per line)</label>
                <textarea class="form-control" id="videos" name="videos" rows="3"></textarea>
            </div>
            <div id="questions-container">
                <div class="form-group">
                    <label>Question 1</label>
                    <textarea class="form-control" name="questions[]" required></textarea>
                    <label>Options</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_option[0]" value="0" required>
                        <input class="form-control" type="text" name="options[0][]" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_option[0]" value="1">
                        <input class="form-control" type="text" name="options[0][]" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_option[0]" value="2">
                        <input class="form-control" type="text" name="options[0][]" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct_option[0]" value="3">
                        <input class="form-control" type="text" name="options[0][]" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addQuestion()">Add Another Question</button>
            <button type="submit" name="add_assignment" class="btn btn-primary">Add Assignment</button>
        </form>
    </div>

    <script>
        let questionCount = 1;

        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questions-container');
            const questionDiv = document.createElement('div');
            questionDiv.classList.add('form-group');
            questionDiv.innerHTML = `
                <label>Question ${questionCount}</label>
                <textarea class="form-control" name="questions[]" required></textarea>
                <label>Options</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_option[${questionCount - 1}]" value="0" required>
                    <input class="form-control" type="text" name="options[${questionCount - 1}][]" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_option[${questionCount - 1}]" value="1">
                    <input class="form-control" type="text" name="options[${questionCount - 1}][]" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_option[${questionCount - 1}]" value="2">
                    <input class="form-control" type="text" name="options[${questionCount - 1}][]" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_option[${questionCount - 1}]" value="3">
                    <input class="form-control" type="text" name="options[${questionCount - 1}][]" required>
                </div>
            `;
            container.appendChild(questionDiv);
        }
    </script>

</body>
</html>
