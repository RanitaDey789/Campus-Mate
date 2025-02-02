<?php
session_start();
if (!isset($_SESSION['f_id']) || empty($_SESSION['f_id'])) {
    header("Location: f_login.php");
    exit();
}

include '../connection.php';

$f_id = $_SESSION['f_id'];

$sql = "SELECT f_name FROM faculty_master WHERE f_id='$f_id'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $f_name = $row['f_name'];
} else {
    $f_name = "User";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/alls.css">
    <title>Results</title>
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
        <div class="welcome">
     <h4>Welcome <?php echo $f_name; ?></h4>
    </div>
    </nav>
    <?php

    // Fetch results from the result table
    $query = "SELECT * FROM results";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Roll No</th><th>Name</th><th>Course Code</th><th>Semester</th><th>Year</th><th>SGPA</th><th>YGPA</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['roll_no'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['course_code'] . "</td>";
            echo "<td>" . $row['sem'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['sgpa'] . "</td>";
            echo "<td>" . $row['ygpa'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
    ?>
    </body>
    </html>