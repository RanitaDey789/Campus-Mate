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
    <h2>Faculty Details</h2>
        <table>
            <tr>
                <th>Faculty ID</th>
                <th>Faculty Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Mobile_no</th>
                <th>Highest Qualificatiom</th>
                <th>Experience</th>
                <th>Date of Joining</th>
            </tr>
            <?php

    $sql = "SELECT f_id, f_name, dept, email, mobile_no, highest_qualification, experience, date_of_joining FROM faculty_master";
    $result = $con->query($sql);

// Check if record exists
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>".$row["f_id"]."</td>";
      echo "<td>".$row["f_name"]."</td>";
      echo "<td>".$row["dept"]."</td>";
      echo "<td>".$row["email"]."</td>";
      echo "<td>".$row["mobile_no"]."</td>";
      echo "<td>".$row["highest_qualification"]."</td>";
      echo "<td>".$row["experience"]."</td>";
      echo "<td>".$row["date_of_joining"]."</td>";
      echo "</tr>";
    }
} else {
    echo "No record found.";
}
$con->close();
?>
        </table>
</body>
</html>
