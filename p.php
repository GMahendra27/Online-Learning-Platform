<!DOCTYPE html>
<html lang="en" ng-app="paymentApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Learning Platform - Payment</title>
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
    
            label {
                font-weight: bold;
            }
    
            input,
            select {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                margin-bottom: 15px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
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
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-controller="PaymentController">

    <div class="container">
        <h2>Payment Details</h2>
        <form id="paymentForm" ng-submit="handlePayment()">
            <!-- Payment information fields -->
            <label for="card-number">Card Number</label>
            <input type="text" id="card-number" name="card-number" maxlength="12" ng-model="cardNumber" ng-change="validateCardNumber()" required>

            <label for="expiry-date">Expiry Date</label>
            <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" ng-model="expiryDate" ng-change="validateExpiryDate()" required>

            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" ng-model="cvv" ng-change="validateCVV()" required>

            


            <!-- Billing information fields -->
            <h3>Billing Information</h3>
            <label for="user-name">Full Name</label>
            <input type="text" id="full-name" name="full-name" ng-model="fullName" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" ng-model="email" required>

            <label for="amount">Enter Amount</label>
            <input type="text" id="amount" name="amount" maxlength="3" ng-model="amount" ng-change="validateCVV()" required>

            <!-- Submit button -->
            <button type="submit">Make Payment</button>
        </form>
        <div id="paymentResult">{{ paymentMessage }}</div>
        <div id="countdown">Time left: <span id="timer">{{ time }}</span></div>
    </div>

    <script>
        var app = angular.module('paymentApp', []);

        app.controller('PaymentController', function ($scope, $interval) {
            // Initialize scope variables
            $scope.cardNumber = '';
            $scope.expiryDate = '';
            $scope.cvv = '';
            $scope.fullName = '';
            $scope.email = '';
            $scope.address = '';
            $scope.city = '';
            $scope.zipCode = '';
            $scope.paymentMessage = '';
            $scope.time = '1:00';

            // Set a time limit for the page (3 minutes in this example)
            var timeLimit = 60; // 3 minutes

            // Update the timer every second
            var countdown = $interval(function () {
                var minutes = Math.floor(timeLimit / 60);
                var seconds = timeLimit % 60;

                // Display the time in the format MM:SS
                $scope.time = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                // Check if the time has run out
                if (timeLimit <= 0) {
                    $interval.cancel(countdown);
                    $scope.paymentMessage = 'Time limit reached. Redirecting or closing the page...';
                    // Add logic for redirecting or closing the page here
                }

                timeLimit--;
            }, 1000);

            $scope.validateCardNumber = function () {
                if (!/^\d{0,12}$/.test($scope.cardNumber)) {
                    alert('Invalid card number. Please enter up to 12 digits.');
                }
            };

            

            $scope.validateCVV = function () {
                if (!/^\d{0,3}$/.test($scope.cvv)) {
                    alert('Invalid CVV. Please enter a maximum of 3 digits.');
                }
            };

            $scope.handlePayment = function () {
                // Add payment handling logic here
                // Simulate payment success
                $scope.paymentMessage = 'Payment Successful';

                // Disable form elements to prevent additional submissions
                angular.element(document.querySelectorAll('#paymentForm input')).prop('disabled', true);

                // Prevent the form from actually submitting
                return false;
            };
        });
    </script>
    <?php
session_start();

// Database connection parameters
$servername = "localhost:3333";
$username = "Mahendra";
$password = "root";
$dbname = "sample";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['uname']);

    // Check if the email or username already exist
    $checkQuery = "SELECT * FROM sample1 WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "Email or username already exists. Please choose a different one.";
    } else {
        // If not, insert data into the database
        $password = $conn->real_escape_string($_POST['psw']);
        $sql = "INSERT INTO sample1 (email, username, password) VALUES ('$email', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>


</body>
</html>
