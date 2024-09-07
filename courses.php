<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Online Learning Platform</title>
    <link rel="stylesheet" href="courses.css">
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
            <a href="course.php">My Courses</a>
            <a href="courses.php">Courses</a>
            <a href="about.html">About us</a>
            
        <input type="text" id="searchInput" placeholder="Search courses...">
        <span class="search-icon">🔍</span>
        <a href="#" class="profile">👤 Profile</a>
    </div>
    <div class="course-search">
        <input type="text" placeholder="Search for courses...">
        <button>Search</button>
    </div>
    <div class="courses-container">
        <div class="course-card">
            <img src="https://e7.pngegg.com/pngimages/758/371/png-clipart-web-development-web-service-web-developer-digital-marketing-develop-trademark-logo.png" alt="Course Logo">
            <div class="course-info">
                <h3>Web Development</h3>
                <p>Instructor: Ist1</p>
                <p>Qualifications: M.Sc. Computer Science</p>
            </div>
            <div class="payment-section">
                <p>Course Fee: $299</p>
                <button onclick="redirectToPayment()">Enroll Now</button>
            </div>
        </div>
        <div class="course-card">
            <img src="https://www.pngitem.com/pimgs/m/157-1576336_machine-learning-logo-png-transparent-png.png" alt="Course Logo">
            <div class="course-info">
                <h3>Machine Learning</h3>
                <p>Instructor: IST 2</p>
                <p>Qualifications: Ph.D. Data Science</p>
            </div>
            <div class="payment-section">
                <p>Course Fee: $199</p>
                <button onclick="redirectToPayment1()">Enroll Now</button>
            </div>
        </div>
        <div class="course-card">
            <img src="https://www.pngitem.com/pimgs/m/11-115358_icon-of-a-cloud-with-the-letters-iot.png" alt="Course Logo">
            <div class="course-info">
                <h3>Internet Of Things</h3>
                <p>Instructor: IST 3</p>
                <p>Qualifications: Ph.D. Artificial Intelligence</p><br>
            </div>
            <div class="payment-section">
                <p>Course Fee: $99</p>
                <button onclick="redirectToPayment2()">Enroll Now</button>
            </div>
        </div>
    </div>
    <script>
        function redirectToPayment() {
            window.location.href = 'payment.php';
        }
    </script>
    <script>
        function redirectToPayment1() {
            window.location.href = 'payment1.php';
        }
    </script>
    <script>
        function redirectToPayment2() {
            window.location.href = 'payment2.php';
        }
    </script>
</body>
</html>





