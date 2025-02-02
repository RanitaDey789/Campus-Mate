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
    <title>View CA</title>
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
<h2>View CA Details</h2>
    <form method="post">
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
            <option value="even">Even</option>
            <option value="odd">Odd</option>
        </select><br><br>
        <label for="year">Select Year:</label>
        <select name="year" id="year">
            <?php
            // Generate options for year dropdown (assuming range from 2010 to current year)
            for ($i = date("Y"); $i >= 2010; $i--) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select><br><br>
        <label for="subject">Select Subject Code:</label>
        <select name="subject" id="subject">
            <option value="PCCCS301">PCCCS301</option>
            <option value="PCCCS602">PCCCS602</option>
            <option value="PCCCS501">PCCCS501</option>
        </select><br><br>
        <input type="submit" name="submit" value="View Details">
    </form>
</body>
</html>
<?php
    // Check if form is submitted
    if(isset($_POST['submit'])) {
        // Get selected options
        $semester = $_POST['semester'];
        $year = $_POST['year'];
        $subject = $_POST['subject'];
        
        // Construct table name
        $table_name = "CA_" . $subject ."_". $semester . "_" . $year;

        // Connect to database (replace with your database credentials)
        include '../connection.php';

        // Query to fetch data from the selected table
        $sql = "SELECT roll_no, file_name FROM $table_name";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Output data in a table
            echo "<table>";
            echo "<tr><th>Roll No</th><th>File Name</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['roll_no'] . "</td>";
                echo "<td><a href='../../uploads/" . $row['file_name'] . "' target='_blank'>" . $row['file_name'] . "</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $con->close();
    }
    ?>