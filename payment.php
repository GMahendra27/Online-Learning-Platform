<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST["course_id"];
    $course_name = $_POST["course_name"];
    $course_cost = $_POST["course_cost"];
    $_SESSION['course_id'] = $course_id; // Store course_id in session for later use

    if (isset($_POST['submitPayment'])) {
        // Validate and process payment
        // Your payment processing logic here

        // For example purposes, we assume payment is successful and save course to user's enrolled courses
        $servername = "127.0.0.1:3333";
        $username = "Mahendra";
        $password = "root"; // Replace with your actual password
        $dbname = "onlinelearning";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            exit('Connection failed'.mysqli_connect_error());
        }

        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session during login
        $sql = "INSERT INTO enrolled_courses (user_id, course_id) VALUES ('$user_id', '$course_id')";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='success-message'>Payment Successful</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'my_courses.php';
                    }, 2000);
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
} else {
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .payment-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        input[type="number"],
        input[type="date"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 4px;
        }
        input[type="number"],
        input[type="date"],
        input[type="text"] {
            background-color: #f8f8f8;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        small {
            font-size: 12px;
            color: #555;
        }
        .cvv-info {
            font-size: 12px;
            color: #555;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
        }
        p.success-message {
            color: green;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Payment Page</h2>
        <form method="post" action="">
            <label for="cardNumber">Card Number:</label>
            <small>Enter 12-digit card number</small>
            <input type="number" id="cardNumber" name="cardNumber" pattern="[0-9]{12}" required>
            
            <label for="expiryDate">Expiry Date:</label>
            <input type="date" id="expiryDate" name="expiryDate" required>

            <label for="cvv">CVV:</label>
            <span class="cvv-info">(Enter 3-digit CVV)</span>
            <input type="text" id="cvv" name="cvv" pattern="[0-9]{3}" required>

            <input type="submit" value="Submit" name="submitPayment">
        </form>
    </div>
</body>
</html>
