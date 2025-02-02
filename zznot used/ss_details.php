<?php
    session_start(); // Start session
    // Check if the user is logged in and session variable 'f_id' is set
    if (!isset($_SESSION['f_id'])) {
        // Redirect to login page or handle the case where user is not logged in
        //header("Location: login.php");
        exit("You are not logged in.");
    }
    // Include the database connection
    include '../connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../styles/alls.css">
</head>
<body>
<nav>
      <div class="logo">
        <img src="../../photos/logo-removebg-preview (1).png" alt="Logo">
      </div>
      <ul class="nav-links">
        <li class="dropdown">
          <a href="faculty.php">Home</a>
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
    </nav>
    <form action="" method="get">
        <button type="submit" name="download">Download Excel</button>
    </form>
    <div class="dist1">
    <h1>Student Details Dashboard</h1>
        <div class="search-container">
            <form action="" method="GET">
                <input type="text" placeholder="Search by Roll No..." name="search">
                <button type="submit">Search</button>
            </form>
        <table>
            <tr>
                <th>Name</th>
                <th>Roll_no</th>
                <th>Reg_no</th>
                <th>Email</th>
                <th>Mobile_no</th>
                <th>Father's Name</th>
                <th>Mother's Name</th>
                <th>Date of Birth</th>
                <th>Course Name</th>
                <th>10th Percentage</th>
                <th>12th Percentage</th>
                <th>Year of Admission</th>
                <th>Department Name</th>
                <th>Department Code</th>
                <th>Address</th>
                <th>Aadhaar Number</th>
                <th>Lateral</th>
                <th>Scholarship</th>
            </tr>
            <?php
            // Database connection
            include '../connection.php';
            // Function to sanitize data for Excel
// // Function to sanitize data for Excel
// function sanitizeForExcel($data) {
//     // Remove HTML tags and trim whitespace
//     $data = strip_tags($data);
//     $data = trim($data);
//     // Escape special characters
//     $data = htmlspecialchars($data, ENT_QUOTES);
//     return $data;
// }
// Check if the "Download Excel" button is pressed
if (isset($_GET['download'])) {
    // Function to sanitize data for Excel
    function sanitizeForExcel($data) {
        // Remove HTML tags and trim whitespace
        $data = strip_tags($data);
        $data = trim($data);
        // Escape special characters
        $data = htmlspecialchars($data, ENT_QUOTES);
        return $data;
    }

// // Prepare Excel file content
 $content = "<tr><th>Name</th><th>Roll_no</th><th>Reg_no</th><th>Email</th><th>Mobile_no</th><th>Father's Name</th><th>Mother's Name</th><th>Date of Birth</th><th>Course Name</th><th>10th Percentage</th><th>12th Percentage</th><th>Year of Admission</th><th>Department Name</th><th>Department Code</th><th>Address</th><th>Aadhaar Number</th><th>Lateral</th><th>Scholarship</th></tr>";

$faculty_id = $_SESSION['f_id'];
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT sm.*
            FROM student_master sm
            INNER JOIN assign_fact2 af ON sm.dept_name = af.sub_dept
            WHERE af.f_id =$faculty_id
            AND roll_no LIKE '%$search%'";
} else {
    $sql = "SELECT sm.*
            FROM student_master sm
            INNER JOIN assign_fact2 af ON sm.dept_name = af.sub_dept
            WHERE af.f_id = $faculty_id";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Sanitize and convert data to Excel format
        $name = sanitizeForExcel($row['s_name']);
        $roll_no = sanitizeForExcel($row['roll_no']);
        $reg_no = sanitizeForExcel($row['reg_no']);
        $email = sanitizeForExcel($row['email']);
        $mobile_no = sanitizeForExcel($row['mobile_no']);
        $father_name = sanitizeForExcel($row['father_name']);
        $mother_name = sanitizeForExcel($row['mother_name']);
        $dob = sanitizeForExcel($row['dob']);
        $course_name = sanitizeForExcel($row['course_name']);
        $tenth_percentage = sanitizeForExcel($row['10th_percentage']);
        $twelfth_percentage = sanitizeForExcel($row['12th_percentage']);
        $year_of_admission = sanitizeForExcel($row['year_of_admission']);
        $dept_name = sanitizeForExcel($row['dept_name']);
        $dept_code = sanitizeForExcel($row['dept_code']);
        $address = sanitizeForExcel($row['address']);
        $aadhar_no = sanitizeForExcel($row['aadhar_no']);
        $lateral = sanitizeForExcel($row['lateral']);
        $scholarship = sanitizeForExcel($row['scholarship']);

        // Concatenate data with tabs and append to content
        $content .= "<tr><th>$name</th><th>$roll_no</th><th>$reg_no</th><th>$email</th><th>$mobile_no</th><th>$father_name</th><th>$mother_name</th><th>$dob</th><th>$course_name</th><th>$tenth_percentage</th><th>$twelfth_percentage</th><th>$year_of_admission</th><th>$dept_name</th><th>$dept_code</th><th>$address</th><th>$aadhar_no</th><th>$lateral</th><th>$scholarship</th><tr>";
 }
}

// Set headers for file download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="student_details.xls"');
header('Cache-Control: max-age=0');

// Output the Excel file content
echo $content;
exit;
}
// Query to fetch student details for displaying on the page
$faculty_id = $_SESSION['f_id'];
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT sm.*
            FROM student_master sm
            INNER JOIN assign_fact2 af ON sm.dept_name = af.sub_dept
            WHERE af.f_id =$faculty_id
            AND roll_no LIKE '%$search%'";
} else {
    $sql = "SELECT sm.*
            FROM student_master sm
            INNER JOIN assign_fact2 af ON sm.dept_name = af.sub_dept
            WHERE af.f_id = $faculty_id";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['s_name']."</td>";                   
        echo "<td>".$row['roll_no']."</td>";
        echo "<td>".$row['reg_no']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['mobile_no']."</td>";
        echo "<td>".$row['father_name']."</td>";
        echo "<td>".$row['mother_name']."</td>";
        echo "<td>".$row['dob']."</td>";
        echo "<td>".$row['course_name']."</td>";
        echo "<td>".$row['10th_percentage']."</td>";
        echo "<td>".$row['12th_percentage']."</td>";
        echo "<td>".$row['year_of_admission']."</td>";
        echo "<td>".$row['dept_name']."</td>";
        echo "<td>".$row['dept_code']."</td>";
        echo "<td>".$row['address']."</td>";
        echo "<td>".$row['aadhar_no']."</td>";
        echo "<td>".$row['lateral']."</td>";
        echo "<td>".$row['scholarship']."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='18'>No results found</td></tr>";
}

$con->close();
?>

        </table>
    </div>
</body>
</html>
