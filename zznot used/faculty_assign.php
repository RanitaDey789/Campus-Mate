<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher assign</title>
    <link rel="stylesheet" href="../styles/a_student_details.css">
</head>
<body>
<h2>Assign Teacher to Subject</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="f_id">Select Faculty:</label>
        <select name="f_id" id="f_id">
        <option disabled selected value>---SELECT THE FACULTY---</option>
            <?php
                // Include the database connection
                include "../connection.php";
                // Fetch faculty data from faculty_master table
                $query = "SELECT * FROM faculty_master";
                $result = mysqli_query($con, $query);

                // Populate dropdown with faculty options
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['f_id'] . "'>" . $row['f_name'] . "</option>";
                }
            ?>
        </select>
        <br><br>
        <label for="sub_code">Select Subject:</label>
        <select name="sub_code" id="sub_code">
        <option disabled selected value>---SELECT THE SUBJECT---</option>
            <?php
                // Fetch subject data from subject_master table
                $query = "SELECT * FROM subject_master";
                $result = mysqli_query($con, $query);

                // Populate dropdown with subject options
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['sub_code'] . "'>" . $row['sub_name'] . "</option>";
                }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Assign">
    </form>

    <?php
        // Handling form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get data from form
            $f_id = $_POST['f_id'];
            $sub_code = $_POST['sub_code'];

            // Insert data into database table for assignment
            $query = "INSERT INTO faculty_subject_assignment (f_id, sub_code) VALUES ('$f_id', '$sub_code')";
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