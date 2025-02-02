<?php
session_start();
if (!isset($_SESSION['roll_no']) || empty($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

include '../connection.php';

$roll_no = $_SESSION['roll_no'];

$sql = "SELECT s_name FROM student_master WHERE roll_no='$roll_no'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['s_name'];
} else {
    $s_name = "User";
}

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
          <a href="student.php">Home</a>
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
     <h4>Welcome <?php echo $name; ?></h4>
    </div>
    </nav>
    <div class="container">
    <h1>Student Details Dashboard</h1>
        <div class="search-container">
        <table>
            
            <?php
            // Database connection
            include '../connection.php';
            $student_id=$_SESSION['roll_no'];
                $sql = "SELECT sm.*
                        FROM student_master sm
                        WHERE sm.roll_no = $student_id";
            
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>Name</td>";
                    echo "<td>".$row['s_name']."</td>";
                    echo "</tr>";
                    echo "<tr>"; 
                    echo "<td>Roll no</td>";               
                    echo "<td>".$row['roll_no']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Reg No</td>";
                    echo "<td>".$row['reg_no']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Email</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Mobile No</td>";
                    echo "<td>".$row['mobile_no']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Father's Name</td>";
                    echo "<td>".$row['father_name']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Mother's Name</td>";
                    echo "<td>".$row['mother_name']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Date of Birth</td>";
                    echo "<td>".$row['dob']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Course Name</td>";
                    echo "<td>".$row['course_name']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>10th Percentage</td>";
                    echo "<td>".$row['10th_percentage']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>12th Percentage</td>";
                    echo "<td>".$row['12th_percentage']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Year of Addmission</td>";
                    echo "<td>".$row['year_of_admission']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Department</td>";
                    echo "<td>".$row['dept_name']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Dept Code</td>";
                    echo "<td>".$row['dept_code']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Address</td>";
                    echo "<td>".$row['address']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Aadhar No</td>";
                    echo "<td>".$row['aadhar_no']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Lateral</td>";
                    echo "<td>".$row['lateral']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Scholarship</td>";
                    echo "<td>".$row['scholarship']."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No results found</td></tr>";
            }
            $con->close();
            ?>
        </table>
    </div>
</body>
</html>
