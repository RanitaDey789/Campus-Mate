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
    </style>
</head>
<body>
<h2>Assign Teacher to Subject</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department">Select Department:</label>
        <select name="department" id="department">
            <option value="CSE">CSE</option>
            <option value="EE">EE</option>
            <option value="ECE">ECE</option>
            <option value="ME">ME</option>
            <option value="CE">CE</option>
        </select>
        <br><br>
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
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
        // Include the database connection
        include '../connection.php';

        // Get data from form
        $department = $_POST['department'];
        $semester = $_POST['semester'];

        // Fetch subjects based on selected department and semester
        $query = "SELECT * FROM subject_master WHERE sub_dept_name = '$department' AND sub_sem = $semester";
        $result = mysqli_query($con, $query);

        // Populate dropdown with subject options
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<label for='subject'>Select Subject:</label>";
        echo "<select name='subject' id='subject'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['sub_code'] . "'>" . $row['sub_name'] . "</option>";
        }
        echo "</select>";
        echo "<br><br>";
        echo "<label for='faculty'>Select Faculty:</label>";
        echo "<select name='faculty' id='faculty'>";
        // Fetch faculty names from faculty_master table
        $query = "SELECT * FROM faculty_master";
        $result = mysqli_query($con, $query);
        // Populate dropdown with faculty options
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['f_id'] . "'>" . $row['f_name'] . "</option>";
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
        //$sub_dept_name = $_POST['department'];
        //$semester = $_POST['semester'];

        // Insert data into fact_assign table
        $query = "INSERT INTO fact_assign (f_id, sub_code) VALUES ('$faculty_id', '$sub_code')";
        //$result = mysqli_query($con, $query);
        $result = mysqli_query($con, $query);

        // Check if insert was successful
        if ($result === true) {
            echo "<p>Assignment successful.</p>";
        } else {
            echo "<p>Error: " . $query . "<br>" . mysqli_error($con) . "</p>";
        }
    }
    ?>
</body>
</html>
