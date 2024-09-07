<?php
session_start();

// Define the quiz questions and answers
$quiz = array(
    1 => array(
        'question' => 'What is the capital of France?',
        'options' => array('Berlin', 'Paris', 'Madrid', 'Rome'),
        'correct_answer' => 'Paris'
    ),
    2 => array(
        'question' => 'Which programming language is used for web development?',
        'options' => array('Java', 'Python', 'HTML', 'PHP'),
        'correct_answer' => 'PHP'
    ),
    3 => array(
        'question' => 'What is the largest planet in our solar system?',
        'options' => array('Earth', 'Mars', 'Jupiter', 'Venus'),
        'correct_answer' => 'Jupiter'
    ),
    // Add more questions here...
);

// Check if the quiz is completed
if (!isset($_SESSION['quiz_score'])) {
    $_SESSION['quiz_score'] = 0;
    $_SESSION['current_question'] = 1;
} elseif (isset($_POST['answer'])) {
    // Check the submitted answer
    $user_answer = $_POST['answer'];
    $correct_answer = $quiz[$_SESSION['current_question']]['correct_answer'];

    // Update the score
    if ($user_answer === $correct_answer) {
        $_SESSION['quiz_score']++;
    }

    // Move to the next question
    $_SESSION['current_question']++;

    // Check if the quiz is completed
    if ($_SESSION['current_question'] > count($quiz)) {
        // Display feedback form if the score is greater than 3
        if ($_SESSION['quiz_score'] > 3) {
            // Redirect to the feedback form
            header("Location: feedback.php");
            exit();
        } else {
            // Quiz completed, redirect to the course page or any other page
            header("Location: course.php");
            exit();
        }
    }
}

// Get the current question
$current_question = $quiz[$_SESSION['current_question']];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: wheat;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: grid;
            gap: 20px;
        }

        button {
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Quiz</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p><?php echo $current_question['question']; ?></p>
        <?php foreach ($current_question['options'] as $option) : ?>
            <label>
                <input type="radio" name="answer" value="<?php echo $option; ?>">
                <?php echo $option; ?>
            </label>
        <?php endforeach; ?>
        <br>
        <button type="submit">Next</button>
    </form>
    <p>Score: <?php echo $_SESSION['quiz_score']; ?></p>
</div>

</body>
</html>
