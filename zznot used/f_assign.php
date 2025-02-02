<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 10px;
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
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

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
    include '../connection.php';

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
            $value = $row['f_id'] . ',' . $row['f_name']; // You can use any delimiter you prefer
            echo "<option value='" . htmlspecialchars($value) . "'>" . $row['f_name'] . "</option>";
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
        $subject_code = $_POST['subject'];
        $semester_assign = $_POST['semester_assign'];
        $subject_department = $_POST['subject_department'];

        // Insert data into fact_assign table
        $query = "INSERT INTO assign_fact (f_id, sub_code, sub_sem, sub_dept) VALUES ('$faculty_id', '$subject_code', '$semester_assign', '$subject_department')";
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
$query = "SELECT f_id, sub_code, sub_sem, sub_dept FROM assign_fact";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fact Assign Table</title>
</head>
<body>
    <h2>Fact Assign Table</h2>
    <table>
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th>Subject Code</th>
                <th>Semester</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['f_id']; ?></td>
                    <td><?php echo $row['sub_code']; ?></td>
                    <td><?php echo $row['sub_sem']; ?></td>
                    <td><?php echo $row['sub_dept']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>