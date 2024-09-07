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

// Check if 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    echo "<script>alert('No assignment ID provided.'); window.location.href='courses.php';</script>";
    exit();
}

$assignment_id = $_GET['id'];

$query = "SELECT * FROM assignments WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Assignment not found.'); window.location.href='courses.php';</script>";
    exit();
}

$assignment = $result->fetch_assoc();

$query_questions = "SELECT * FROM questions WHERE assignment_id = ?";
$stmt_questions = $conn->prepare($query_questions);
$stmt_questions->bind_param("i", $assignment_id);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();

$questions = [];
while ($row = $result_questions->fetch_assoc()) {
    $questions[] = $row;
}

// Close the statements but keep the connection open
$stmt->close();
$stmt_questions->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assignment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4"><?php echo htmlspecialchars($assignment['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($assignment['description'])); ?></p>

    <form method="post" action="submit_assignment.php">
        <?php foreach ($questions as $index => $question): ?>
            <div class="form-group">
                <label><?php echo htmlspecialchars($question['question_text']); ?></label>
                <?php
                $query_options = "SELECT * FROM options WHERE question_id = ?";
                $stmt_options = $conn->prepare($query_options);
                $stmt_options->bind_param("i", $question['id']);
                $stmt_options->execute();
                $result_options = $stmt_options->get_result();

                while ($option = $result_options->fetch_assoc()):
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $option['id']; ?>" required>
                        <label class="form-check-label"><?php echo htmlspecialchars($option['option_text']); ?></label>
                    </div>
                <?php endwhile; ?>
                <?php
                $stmt_options->close();
                ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Submit Assignment</button>
    </form>
</div>
<?php $conn->close(); ?>
</body>
</html>
