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
<h2>View CA details</h2>
    <form method="post">
    <label for="ca">Select CA:</label>
        <select name="ca" id="ca">
            <option value="ca1">CA 1</option>
            <option value="ca2">CA 2</option>
            <option value="ca3">CA 3</option>
        </select>
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
        $ca = $_POST['ca'];
        $semester = $_POST['semester'];
        $year = $_POST['year'];
        $subject = $_POST['subject'];
        
        // Construct table name
        $table_name = $ca . "_" . $subject ."_". $semester . "_" . $year;

        

        // Query to fetch data from the selected table
        $sql = "SELECT roll_no, file_name FROM $table_name";
        try {$result = $con->query($sql);
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
        }
        catch (mysqli_sql_exception $e) {
               // Check if the error message contains the specified text
    if (strpos($e->getMessage(), "Table 'bbs.ca3_pcccs501_odd_2024' doesn't exist") !== false) {
        // Display your custom error message with styling
        echo "Mentioned table is not available</>";
    } else {
        // Display the original error message if it's not related to the table not existing
        //echo "An error occurred: " . $e->getMessage();       //for debugging
        echo "Mentioned table is not available. Please try something else or recheck.</>";
    }
        }

        
        $con->close();
    }
    ?>