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
// Fetch faculty details
$f_id = $_SESSION['f_id'];
$sql = "SELECT f_id, f_name, dept, email, mobile_no, highest_qualification, experience, date_of_joining FROM faculty_master WHERE f_id = '$f_id'";
$result = $con->query($sql);

// Check if record exists
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $f_id = $row["f_id"];
        $f_name = $row["f_name"];
        $dept = $row["dept"];
        $email = $row["email"];
        $mobile_no = $row["mobile_no"];
        $highest_qualification = $row["highest_qualification"];
        $experience = $row["experience"];
        $date_of_joining = $row["date_of_joining"];
    }
} else {
    echo "No record found.";
}
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Details</title>
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
    <div class="container">
        <h2>Faculty Details</h2>
        <table>
            <tr>
                <td>Faculty ID:</td>
                <td><?php echo $f_id; ?></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><?php echo $f_name; ?></td>
            </tr>
            <tr>
                <td>Department:</td>
                <td><?php echo $dept; ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td>Mobile Number:</td>
                <td><?php echo $mobile_no; ?></td>
            </tr>
            <tr>
                <td>Highest Qualification:</td>
                <td><?php echo $highest_qualification; ?></td>
            </tr>
            <tr>
                <td>Experience:</td>
                <td><?php echo $experience; ?></td>
            </tr>
            <tr>
                <td>Date of Joining:</td>
                <td><?php echo $date_of_joining; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
