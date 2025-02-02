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
    <title>Assign Faculty</title>
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department">Select Department:</label>
        <select name="department" id="department">
            <option value='' disabled selected>Select a department</option>
            <option value="CSE">CSE</option>
            <option value="EE">EE</option>
            <option value="ECE">ECE</option>
            <option value="ME">ME</option>
            <option value="CE">CE</option>
        </select>
        <br><br>
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
        <option value='' disabled selected>Select a semester</option>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <br><br>
        <input type="submit" name="go" value="Go">
    </form>


    <?php
    $year=2020;
    // Handling form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['go'])) {
        // Get data from form
        $department = $_POST['department'];
        $semester = $_POST['semester'];

        // Fetch subjects based on selected department and semester
        $query = "SELECT * FROM subject_master WHERE sub_dept_name = '$department' AND sub_sem = $semester";
        $result = mysqli_query($con, $query);
        echo"<br><br>";
        // Populate dropdown with subject options
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<label for='subject'>Select Subject:</label>";
        echo "<select name='subject' id='subject'>";
        echo "<option value='' disabled selected>Select an option</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['sub_code'] . "'>" . $row['sub_name'] . "</option>";
        }
        // while ($row = mysqli_fetch_assoc($result)) {
        //     $value = $row['sub_code'] . ' ' . $row['sub_name'];
        //     echo "<option value='" . htmlspecialchars($value) . "'>" . $row['sub_name'] . "</option>";
        // }
        echo "</select>";
        echo "<br><br>";
        
        // Fetch semester data from subject_master table
        echo "<label for='semester_assign'>Select Semester Assign:</label>";
        echo "<select name='semester_assign' id='semester_assign'>";
        echo "<option value='' disabled selected>Select an option</option>";
        echo "<option value='1'>1</option>";
        echo "<option value='2'>2</option>";
        echo "<option value='3'>3</option>";
        echo "<option value='4'>4</option>";
        echo "<option value='5'>5</option>";
        echo "<option value='6'>6</option>";
        echo "<option value='7'>7</option>";
        echo "<option value='8'>8</option>";
        echo "</select>";
        echo "<br><br>";

        // Fetch unique department names from subject_master table
        $query = "SELECT DISTINCT sub_dept_name FROM subject_master";
        $result = mysqli_query($con, $query);
        
        // Populate dropdown with subject department options
        echo "<label for='subject_department'>Select Subject Department:</label>";
        echo "<select name='subject_department' id='subject_department'>";
        echo "<option value='' disabled selected>Select an option</option>";
        
         while ($row = mysqli_fetch_assoc($result)) {
             echo "<option value='" . $row['sub_dept_name'] . "'>" . $row['sub_dept_name'] . "</option>";
         }
        echo "</select>";
        echo "<br><br>";

        echo "<label for='faculty'>Select Faculty:</label>";
        echo "<select name='faculty' id='faculty'>";
        echo "<option value='' disabled selected>Select an option</option>";
        // Fetch faculty names from faculty_master table
        $query = "SELECT * FROM faculty_master";
        $result = mysqli_query($con, $query);
        // Populate dropdown with faculty options
        while ($row = mysqli_fetch_assoc($result)) {
            $value = $row['f_id'] . ' ' . $row['f_name']; // You can use any delimiter you prefer
            echo "<option value='" . htmlspecialchars($value) . "'>" . $row['f_name'] . "</option>";
        }
        echo "<br><br>";
        echo"<label for='year'>Select Year :</label>";
        echo"<input type='text' id='year' name='year' required>";
                
        echo "<input type='submit' name='assign' value='Assign'>";
        echo "</form>";
    }

    // Handling form submission for assigning faculty to subject
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign'])) {
        // Get data from form
        $faculty_id = $_POST['faculty'];
        //$faculty_name= $POST['f_name'];
        $subject_code = $_POST['subject'];
        $semester_assign = $_POST['semester_assign'];
        $subject_department = $_POST['subject_department'];
        $year = $_POST['year'];
       // $subject_name = $POST['sub_name'];

        // Insert data into fact_assign table
        $query = "INSERT INTO assign_fact2 (f_id, sub_code, sub_sem, sub_dept, a_year) VALUES ('$faculty_id', '$subject_code', '$semester_assign', '$subject_department', '$year')";
        $result = mysqli_query($con, $query);

        // Check if insert was successful
        if ($result === true) {
            echo "<p>Assignment successful.</p>";
        } else {
            echo "<p>Error: " . $query . "<br>" . mysqli_error($con) . "</p>";
        }
    }
    ?>
    <?php
// Include the database connection
include '../connection.php';

// Fetch data from the fact_assign table
//$query = "SELECT f_id, sub_code, sub_sem, sub_dept FROM assign_fact2";
$query ="SELECT a.f_id, a.sub_code, a.sub_sem, a.sub_dept,a.a_year, f.f_name
FROM assign_fact2 a
INNER JOIN faculty_master f ON a.f_id = f.f_id";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fact Assign Table</title>
    <link rel="stylesheet" href="../styles/fact_assign.css">
</head>
<body>
    <h2>Fact Assign Table</h2> <br>
    <table>
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th>Faculty Name</th>
                <th>Subject Code & Subject Name</th>
                <th>Semester</th>
                <th>Department</th>
                <th>year</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['f_id']; ?></td>
                    <td><?php echo $row['f_name']; ?></td>
                    <td><?php echo $row['sub_code']; ?></td>
                    <td><?php echo $row['sub_sem']; ?></td>
                    <td><?php echo $row['sub_dept']; ?></td>
                    <td><?php echo $row['a_year']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>