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

// Retrieve the roll number of the logged-in student
$roll_no = $_SESSION['roll_no'];

// Query to fetch the department name of the logged-in student
$query = "SELECT dept_name FROM student_master WHERE roll_no = '$roll_no'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$dept_name = $row['dept_name'];

// Query to retrieve study materials associated with the student's department
$query = "SELECT study_mat.* FROM study_mat
          INNER JOIN subject_master ON study_mat.subject = subject_master.sub_code
          WHERE subject_master.sub_dept_name = '$dept_name'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Study Material</title>
    <link rel="stylesheet" href="../styles/alls.css">

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
    <h2>Study Material</h2>
    <table>
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Material</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['subject']; ?></td>
                <td><a href="../../uploads/<?php echo $row['file_name']; ?>" target="_blank">View Material For The Subject</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
