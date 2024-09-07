<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Online Learning Platform</title>

    <link rel="stylesheet" href="home.css">
    <!-- <script src="home.js" defer></script> -->
</head>
<body>
    <div class="navbar">
        
        
        <img src="1599153152367-removebg-preview.png" alt="No image" width="15%">
        <div class="menu">
            <a href="home1.php">Home</a>
            <a href="my_courses.php">My Courses</a>
            <a href="show_courses.php">Courses</a>
            <a href="enroll_course.php">Enroll Courses</a>
            <input class="input-box" type="text" id="searchInput" style="color: black; margin-top:7px; border:2px solid black;" placeholder="Search courses...">
            <span class="search-icon" onclick="searchCourses()">🔍</span>
        </div>
        <div class="user">
            <a href="profile.php" class="profile">👤 Profile</a>
            <a href="index.php" class="logout">Logout</a>
        </div>
    </div>
    <div class="hero-section">
        <h1>Welcome to the CoreTel</h1>
        <p>Empower your learning journey with our diverse range of courses.</p>
    </div>
    <div class="course-progress">
        <h2>Our Courses</h2>
        <div class="course">
            <p>Course 1: Web Development</p>
            <progress value="20" max="100"></progress>
            <span>20%</span>
        </div>
        <div class="course">
            <p>Course 2: Machine Learning</p>
            <progress value="40" max="100"></progress>
            <span>40%</span>
        </div>
        <div class="course">
            <p>Course 3: Internet Of Things</p>
            <progress value="40" max="100"></progress>
            <span>40%</span>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0099ff" fill-opacity="1" d="M0,224L40,224C80,224,160,224,240,202.7C320,181,400,139,480,133.3C560,128,640,160,720,186.7C800,213,880,235,960,224C1040,213,1120,171,1200,160C1280,149,1360,171,1400,181.3L1440,192L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>
    <footer>
        <p>&copy; 2023 Online Learning Platform. All rights reserved.</p>
        <p>Contact: batch15@gmail.com | Address: vadlamudi vfstr</p>
    </footer>
    
</body>
</html>

