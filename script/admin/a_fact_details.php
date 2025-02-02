<?php

    session_start();
    // Check if user is logged in
    if (!isset($_SESSION['a_id'])) {
    header("Location: a_login.php"); // Redirect to login page if not logged in
    exit();
    }
    // Connect to database (replace with your database credentials)
    include '../connection.php';
    $a_id = $_SESSION['a_id'];
    
    $sql = "SELECT a_name FROM admin_master WHERE a_id='$a_id'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['a_name'];
    } else {
        $name = "User";
    }
    // Initialize error message variable
    $error_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_id = $_POST['f_id'];
    // Check if f_id already exists
    $check_query = "SELECT * FROM faculty_master WHERE f_id='$f_id'";
    $result = $con->query($check_query);
    if ($result->num_rows > 0) {
        $error_message = "This faculty ID already exists in the database. Please try a new one.";
    } else {
        // If f_id doesn't exist, proceed with insertion
        $f_name = $_POST['f_name'];
        $dept = $_POST['dept'];
        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];
        $highest_qualification = $_POST['highest_qualification'];
        $experience = $_POST['experience'];
        $date_of_joining = $_POST['date_of_joining'];
        $password = $_POST['password'];

        // Prepare SQL statement to insert data into student_master table
        $sql = "INSERT INTO `faculty_master`(`f_id`, `f_name`, `dept`, `email`, `mobile_no`, `highest_qualification`, `experience`, `date_of_joining`, `password`) VALUES ('$f_id','$f_name','$dept','$email','$mobile_no','$highest_qualification','$experience','$date_of_joining','$password')";

        if ($con->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}

// Close connection
$con->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Faculty Details Form</title>
    <link rel="stylesheet" href="../styles/alls.css">
</head>
<body>
<nav>
      <div class="logo">
        <img src="../../photos/logo-removebg-preview (1).png" alt="Logo">
      </div>
      <ul class="nav-links">
        <li class="dropdown">
          <a href="admin.php">Home</a>
        </li>
        <li class="dropdown">
          <a href="#">About Us</a>
          <div class="dropdown-content">
            <a href="#">Sublink 1</a>
            <a href="#">Sublink 2</a>
            <a href="#">Sublink 3</a>
          </div>
        </li>
      </ul>
        <form action="../logout.php" method="post">
            <input type="submit" value="Logout">
        </form>
        <div class="welcome">
     <h3>Welcome <?php echo $name; ?></h3>
    </div>
    </nav>
    <h2>Enter Faculty Details</h2>
    <form action="" method="post">
        <label for="f_id">Faculty ID:</label>
        <input type="text" id="f_id" name="f_id" required><br><br>

        <label for="f_name">Faculty Name:</label>
        <input type="text" id="f_name" name="f_name" required><br><br>

        <label for="dept">Select Department:</label>
        <select name="dept" id="dept">
            <option value='' disabled selected>Select a department</option>
            <option value="CSE">CSE</option>
            <option value="EE">EE</option>
            <option value="ECE">ECE</option>
            <option value="ME">ME</option>
            <option value="CE">CE</option>
        </select>

        <label for="email">Email id:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label for="mobile_no">Mobile Number:</label>
        <input type="text" id="mobile_no" name="mobile_no" required><br><br>

        <label for="highest_qualification">Highest Qualification:</label>
        <input type="text" id="highest_qualification" name="highest_qualification" required><br><br>

        <label for="experience">Experience (in year):</label>
        <input type="text" id="experience" name="experience" required><br><br>

        <label for="date_of_joining">Date of joining:</label>
        <input type="date" id="date_of_joining" name="date_of_joining" required><br><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
