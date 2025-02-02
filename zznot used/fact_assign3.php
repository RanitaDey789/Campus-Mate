<!DOCTYPE html>
<html>
<head>
    <title>Assign Teacher to Subject</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        form {
            width: 50%;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"], input[type="button"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php
// Include the database connection
include 'connection.php';

// Fetch data from the fact_assign table
$query = "SELECT f_id, sub_dept, sub_name, sub_sem FROM fact_assign";
$result = mysqli_query($connection, $query);
?>
<h2>Fact Assign Table</h2>
    <table>
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th>Subject Department</th>
                <th>Subject Name</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['f_id']; ?></td>
                    <td><?php echo $row['sub_dept']; ?></td>
                    <td><?php echo $row['sub_name']; ?></td>
                    <td><?php echo $row['sub_sem']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<h2>Assign Teacher to Subject</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="dep">Select Department:</label>
        <select name="dep" id="dep">
        <option value="CSE" <?php if(isset($_POST['dep']) && $_POST['dep'] == 'CSE') echo 'selected'; ?>>CSE</option>
            <option value="EE" <?php if(isset($_POST['dep']) && $_POST['dep'] == 'EE') echo 'selected'; ?>>EE</option>
            <option value="ECE" <?php if(isset($_POST['dep']) && $_POST['dep'] == 'ECE') echo 'selected'; ?>>ECE</option>
            <option value="ME" <?php if(isset($_POST['dep']) && $_POST['dep'] == 'ME') echo 'selected'; ?>>ME</option>
            <option value="CE" <?php if(isset($_POST['dep']) && $_POST['dep'] == 'CE') echo 'selected'; ?>>CE</option>
        </select>
        <br><br>
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>" <?php if(isset($_POST['semester']) && $_POST['semester'] == $i) echo 'selected'; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <br><br>
        <input type="submit" name="go" value="Go">
    </form>

    <?php
    $department ='';
    include '../connection.php';
    // Handling form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['go'])) {
        // Include the database connection
        

        // Get data from form
        $department = $_POST['dep'];
        $semester = $_POST['semester'];

        // Fetch subjects based on selected department and semester
        $query = "SELECT * FROM subject_master WHERE sub_dept_name = '$department' AND sub_sem = $semester";
        $result = mysqli_query($con, $query);

        // Populate dropdown with subject options
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";

        echo "<label for='faculty'>Select Faculty:</label>";
        echo "<select name='faculty' id='faculty'>";
        // Fetch faculty names from faculty_master table
        $querys = "SELECT * FROM faculty_master";
        $results = mysqli_query($con, $querys);
        // Populate dropdown with faculty options
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<option value='" . $row['f_id'] . "'>" . $row['f_name'] . "</option>";
        }
        echo "</select>";
        echo "<br><br>";
        echo "<label for='subject'>Select Subject:</label>";
        echo "<select name='subject' id='subject'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['sub_code'] . "'>" . $row['sub_name'] . "</option>";
        }
        echo "</select>";
        echo "<br><br>";
        
        
        echo "<input type='submit' name='assign' value='Assign'>";
        echo "</form>";
    }
    
    // Handling form submission for assigning faculty to subject
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign'])) {
        // Get data from form
        $faculty_id = $_POST['faculty'];
        //$faculty_name = $_POST['faculty_name'];
        $sub_code = $_POST['subject'];
        
        $department = $_POST['dep'];
        //$semester = $_POST['semester'];

        // Fetch department ID from 'departments' table
        $query = "SELECT sub_dept_name FROM subject_master WHERE sub_dept_name = '$department'";
        $result = mysqli_query($con, $query);

        // Check if query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $sub_dept_name = $row['sub_dept_name'];
        

        // Insert data into fact_assign table
        $query = "INSERT INTO fact_assign_2 (f_id, sub_code, sub_dept) VALUES ('$faculty_id', '$sub_code', '$sub_dept_name')";
        //$result = mysqli_query($con, $query);
        $result = mysqli_query($con, $query);

        // Check if insert was successful
        if ($result === true) {
            echo "<p>Assignment successful.</p>";
        } else {
            echo "<p>Error: " . $query . "<br>" . mysqli_error($con) . "</p>";
        }
    }
    }
    ?>
</body>
</html>
