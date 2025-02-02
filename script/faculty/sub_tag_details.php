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
<!-- sub_tag_details.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Tag Details</title>
    <link rel="stylesheet" href="../styles/alls.css">
    
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

    <h2>Subject Tag Details</h2>
    <table>
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Semester</th>
                <th>Subject Department</th>
                <th>Academic Year</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //$faculty_id = $_SESSION['f_id'];
            // // Fetch data from fact_assign and subject_master tables
            // $query = "SELECT f_assign.f_id, f_assign.sub_sem, s.sub_code, s.sub_dept_name
            // FROM fact_assign f_assign
            // INNER JOIN subject_master s ON f_assign.sub_code = s.sub_code
            // WHERE f_assign.f_id = '$faculty_id'
            // AND s.sub_dept_name = s.sub_dept_name";
            // $result = mysqli_query($con, $query);

        $faculty_id=$_SESSION['f_id'];
        $query = "SELECT a.sub_code, a.sub_sem, a.sub_dept, a.a_year
        FROM assign_fact2 a WHERE a.f_id = $faculty_id";
        $result = mysqli_query($con, $query);

            // Check if query was successful
            if ($result && mysqli_num_rows($result) > 0) {
                // Output data rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['sub_code'] . "</td>";
                    echo "<td>" . $row['sub_sem'] . "</td>";
                    echo "<td>" . $row['sub_dept'] . "</td>";
                    echo "<td>" . $row['a_year'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>


<!-- 
    1. student subject assign
-->