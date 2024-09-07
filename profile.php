<!-- profile.php -->
<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    echo "User not logged in.";
    exit();
}

// Database connection parameters
$servername = "localhost:3307";
$username = "Mahendra";
$password = "root";
$dbname = "onlinelearning";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database
$user = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$user'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $ur = $row['username'];
    $eml = $row['full_name'];
    $phone = $row['phone_number'];
} else {
    echo "User not found in the database.";
    exit();
}

// Close connection
$conn->close();

// Check if the form is submitted for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user details in the database
    $newFullName = $_POST['new_full_name'];
    $newPhoneNumber = $_POST['new_phone_number'];
    $newPassword = $_POST['new_password'];

    // Perform validation and update operations
    // (You should add proper validation and hashing for the password before updating)

    // Update user details in the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateSql = "UPDATE users SET full_name = '$newFullName', phone_number = '$newPhoneNumber', password = '$newPassword' WHERE username = '$user'";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        // Redirect to the profile page after successful update
        header("Location: profile.php");
        exit();
    } else {
        echo "Update failed. Please try again.";
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" ng-app="profileApp" ng-controller="profileCtrl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Online Learning Platform</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="profile-container bg-light p-4">
            <h1 class="mb-4">Your Profile</h1>
            <p><strong>Username:</strong> {{user.username}}</p>
            <p><strong>Welcome:</strong> {{user.full_name}}</p>
            <p><strong>Phone Number:</strong> {{user.phone_number}}</p>

            <!-- Edit form -->
            <form name="editProfileForm" action="profile.php" method="post" novalidate>
                <div class="form-group">
                    <label for="new_full_name">New Full Name:</label>
                    <input type="text" id="new_full_name" name="new_full_name" class="form-control" ng-pattern="/^[^\s]+$/" ng-model="newUser.full_name" required ng-pattern="/^[A-Za-z\s]+$/">
                    <div class="text-danger" ng-show="editProfileForm.new_full_name.$dirty && editProfileForm.new_full_name.$error.required">Full Name is required.</div>
                    <div class="text-danger" ng-show="editProfileForm.new_full_name.$dirty && editProfileForm.new_full_name.$error.pattern">Full Name must contain only alphabets.</div>
                </div>

                <div class="form-group">
                    <label for="new_phone_number">New Phone Number:</label>
                    <input type="tel" id="new_phone_number" name="new_phone_number" class="form-control" ng-model="newUser.phone_number" required ng-pattern="/^\d{10}$/">
                    <div class="text-danger" ng-show="editProfileForm.new_phone_number.$dirty && editProfileForm.new_phone_number.$error.required">Phone Number is required.</div>
                    <div class="text-danger" ng-show="editProfileForm.new_phone_number.$dirty && editProfileForm.new_phone_number.$error.pattern">Phone Number must contain exactly 10 digits.</div>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" ng-model="newUser.new_password" required ng-minlength="4" ng-pattern="/^[^\s]+$/">
                    <div class="text-danger" ng-show="editProfileForm.new_password.$dirty && editProfileForm.new_password.$error.required">Password is required.</div>
                    <div class="text-danger" ng-show="editProfileForm.new_password.$dirty && editProfileForm.new_password.$error.minlength">Password must be at least 4 characters long.</div>
                    <div class="text-danger" ng-show="editProfileForm.new_password.$dirty && editProfileForm.new_password.$error.pattern">Password must not contain spaces.</div>
                </div>

                <div class="form-group">
                    <input type="submit" value="Update" ng-disabled="editProfileForm.$invalid" class="btn btn-primary">
                </div>
            </form>

            <a href="index.php" class="mt-3 btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- AngularJS script -->
    <script>
        var profileApp = angular.module('profileApp', []);
        profileApp.controller('profileCtrl', function ($scope) {
            $scope.user = {
                username: '<?php echo $ur; ?>',
                full_name: '<?php echo $eml; ?>',
                phone_number: '<?php echo $phone; ?>'
            };

            $scope.newUser = {
                full_name: '',
                phone_number: '',
                new_password: ''
            };
        });
    </script>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
