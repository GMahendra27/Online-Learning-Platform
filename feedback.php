<!-- feedback.php -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Feedback Form</title>
</head>

<body>

  <div class="container">
    <h1>Feedback Form</h1>
    <form action="submit_feedback.php" method="post">
      <label for="feedback">Your Feedback:</label>
      <textarea id="feedback" name="feedback" rows="4" cols="50" required></textarea>
      <br>
      <button type="submit" class="button">Submit Feedback</button>
    </form>
  </div>

  <style>
    /* Add this to your existing styles.css file */

body {
  font-family: 'Poppins', sans-serif;
  background: #b9b3a9;
  display: flex;
  justify-content: center;
}

.container {
  width: 400px;
  padding: 20px;
  margin-top: 80px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 20px;
}

h1 {
  text-align: center;
  color: firebrick;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

label {
  margin-bottom: 10px;
  font-weight: bold;
}

textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 10px 20px;
  background-color: rgb(66, 202, 89);
  color: #fff;
  border: none;
  cursor: pointer;
  font-size: 16px;
  border-radius: 4px;
  transition: background-color 0.3s;
}

button:hover {
  background-color: rgb(23, 144, 12);
}

  </style>
<!-- submit_feedback.php -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST["feedback"];

    // Process the feedback (you can save it to a database, send an email, etc.)
    
    // For this example, we'll just display the feedback.
    echo "<p>Thank you for your feedback:</p>";
    echo "<p>$feedback</p>";
} else {
    // If the form is not submitted through POST, redirect to the feedback form.
    header("Location: feedback.php");
    exit();
}

?>


</body>

</html>
