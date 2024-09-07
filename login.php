<?php
session_start();
$server = "127.0.0.1:3307";
$username = "Mahendra";
$password = "root";
$database = "onlinelearning";
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    exit('Connection failed' . mysqli_connect_error());
}

if (isset($_POST['login_submit'])) {
    $username = $_POST['usr_l'];
    $password = $_POST['pwd_l'];
    $role = $_POST['role_l'];

    // Use prepared statement to prevent SQL injection
    $qry = "SELECT * FROM users WHERE username=? AND password=? AND role=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id']; // Store user_id in session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'administration') {
            echo "<script>window.location.href = 'home1.php';</script>";
        } else {
            echo "<script>window.location.href = 'home.php';</script>";
        }
    } else {
        echo "<script>alert('Login Failed'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
}

if (isset($_POST['register_submit'])) {
    $fullname = $_POST['full_name'];
    $username = $_POST['usr_r'];
    $password = $_POST['pwd_r'];
    $phoneNumber = $_POST['contact'];
    $role = $_POST['role_r']; // Get the role from the form

    $qry0 = "SELECT * FROM users WHERE username='$username'";
    $res0 = mysqli_query($conn, $qry0);
    if (mysqli_num_rows($res0) == 1) {
        echo "<script>alert('Username exists');</script>";
    } else {
        $qry = "INSERT INTO users (full_name, username, password, phone_number, role) VALUES ('$fullname', '$username', '$password', '$phoneNumber', '$role')";
        $res = mysqli_query($conn, $qry);
        if ($res) {
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Registration Failed');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-center mt-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="b1" data-toggle="tab" href="#Login" onclick="display(event,'Login')">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="b2" data-toggle="tab" href="#Register" onclick="display(event,'Register')">Register</a>
            </li>
        </ul>
    </div>
    <div ng-app="formApp" ng-controller="formCtrl" class="tab-content mt-3">
        <div id="Login" class="tab-pane fade show active">
            <form name="loginForm" action="login.php" method="post" novalidate>
                <div class="form-group">
                    <label for="usr_l">Username</label>
                    <input type="text" class="form-control" id="usr_l" name="usr_l" ng-model="user.usr_l" required ng-pattern="/^[^\s]+$/">
                    <div class="text-danger" ng-show="loginForm.usr_l.$dirty && loginForm.usr_l.$error.required">Username is required.</div>
                    <div class="text-danger" ng-show="loginForm.usr_l.$error.pattern">Username must not contain spaces.</div>
                </div>
                <div class="form-group">
                    <label for="pwd_l">Password</label>
                    <input type="password" class="form-control" id="pwd_l" name="pwd_l" ng-model="user.pwd_l"
                           required ng-minlength="4" ng-pattern="/^[^\s]+$/">
                    <div class="text-danger" ng-show="loginForm.pwd_l.$error.minlength">Password must be at least 4 characters long.</div>
                    <div class="text-danger" ng-show="loginForm.pwd_l.$error.pattern">Password must not contain spaces.</div>
                </div>
                <div class="form-group">
                    <label for="role_l">Role</label>
                    <select id="role_l" class="form-control" name="role_l" ng-model="user.role_l" required>
                        <option value="user">User</option>
                        <option value="administration">Administration</option>
                    </select>
                    <div class="text-danger" ng-show="loginForm.role_l.$dirty && loginForm.role_l.$error.required">Role is required.</div>
                </div>
                <div class="form-group">
                    <input type="reset" class="btn btn-secondary">
                    <input type="submit" name="login_submit" value="Login" ng-disabled="loginForm.$invalid" class="btn btn-primary">
                </div>
            </form>
        </div>

        <div id="Register" class="tab-pane fade">
            <form name="registerForm" action="login.php" method="post" novalidate>
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" ng-model="user.full_name"
                           required ng-pattern="/^[A-Za-z\s]+$/">
                    <div class="text-danger" ng-show="registerForm.full_name.$dirty && registerForm.full_name.$error.required">Full Name is required.</div>
                    <div class="text-danger" ng-show="registerForm.full_name.$dirty && registerForm.full_name.$error.pattern">Full Name must contain only alphabets.</div>
                </div>
                <div class="form-group">
                    <label for="usr_r">Username</label>
                    <input type="text" id="usr_r" class="form-control" name="usr_r" ng-model="user.usr_r"
                           required ng-pattern="/^[^\s]+$/">
                    <div class="text-danger" ng-show="registerForm.usr_r.$dirty && registerForm.usr_r.$error.required">Username is required.</div>
                    <div class="text-danger" ng-show="registerForm.usr_r.$dirty && registerForm.usr_r.$error.pattern">Username must not contain spaces.</div>
                </div>
                <div class="form-group">
                    <label for="pwd_r">Password</label>
                    <input type="password" id="pwd_r" class="form-control" name="pwd_r" ng-model="user.pwd_r"
                           ng-minlength="4" required ng-pattern="/^[^\s]+$/">
                    <div class="text-danger" ng-show="registerForm.pwd_r.$dirty && registerForm.pwd_r.$error.required">Password is required.</div>
                    <div class="text-danger" ng-show="registerForm.pwd_r.$dirty && registerForm.pwd_r.$error.minlength">Password must be at least 4 characters long.</div>
                    <div class="text-danger" ng-show="registerForm.pwd_r.$dirty && registerForm.pwd_r.$error.pattern">Password must not contain spaces.</div>
                </div>
                <div class="form-group">
                    <label for="contact">Phone Number</label>
                    <input type="tel" id="contact" class="form-control" name="contact" ng-model="user.contact"
                           required ng-pattern="/^\d{10}$/">
                    <div class="text-danger" ng-show="registerForm.contact.$dirty && registerForm.contact.$error.required">Phone Number is required.</div>
                    <div class="text-danger" ng-show="registerForm.contact.$dirty && registerForm.contact.$error.pattern">Phone Number must contain exactly 10 digits.</div>
                </div>
                <div class="form-group">
                    <label for="role_r">Role</label>
                    <select id="role_r" class="form-control" name="role_r" ng-model="user.role_r" required>
                        <option value="user">User</option>
                        <option value="administration">Administration</option>
                    </select>
                    <div class="text-danger" ng-show="registerForm.role_r.$dirty && registerForm.role_r.$error.required">Role is required.</div>
                </div>
                <div class="form-group">
                    <input type="reset" class="btn btn-secondary">
                    <input type="submit" name="register_submit" value="Register" ng-disabled="registerForm.$invalid" class="btn btn-primary">
                </div>
            </form>
        </div>
        <script>
            var formApp = angular.module('formApp', []);
            formApp.controller('formCtrl', function ($scope) {
                $scope.user = {
                    usr_l: '',
                    pwd_l: '',
                    role_l: 'user', // Default role for login is user
                    full_name: '',
                    usr_r: '',
                    pwd_r: '',
                    contact: '',
                    role_r: 'user' // Default role for registration is user
                };
            });
        </script>
    </div>
</div>

<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
