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
           

            

            <input type="submit" value="Submit" name="submitPayment1">
        </form>

        <?php
        if (isset($_POST['submitPayment1'])) {
            // Validate and process payment
            // Your payment processing logic here

            // Print success message
            echo "<p class='success-message'>Payment Successful</p>";

            // Redirect to home1.php after a brief delay (you can adjust the delay)
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'home1.php';
                    }, 2000); // 2000 milliseconds (2 seconds) delay
                  </script>";
        }
        ?>
    </div>
</body>
</html>
