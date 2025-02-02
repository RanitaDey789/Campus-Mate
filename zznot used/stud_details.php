<?php
    session_start();
    if (!isset($_SESSION['roll_no']) || empty($_SESSION['roll_no'])) {
        header("Location: login.php");
        exit();
    }
    
    include '../connection.php';
    
    $roll_no = $_SESSION['roll_no'];
    
    $sql = "SELECT name FROM signup WHERE roll_no='$roll_no'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    } else {
        $name = "User";
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = $_POST['blood_type'];
    $department = $_POST['department'];
    $abc_id = $_POST['abc_id'];
    $address = $_POST['address'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $home_contact = $_POST['home_contact'];

    // File upload handling
    $target_file = $_FILES['student_photo']['name'];
    $tempname=$_FILES['student_photo']['tmp_name'];
    $target_dir = "../../uploads/".$target_file;
    move_uploaded_file($tempname, $target_dir);

    // Insert data into database
    $sql = "INSERT INTO student_details (blood_type, department, abc_id, address, father_name, mother_name, home_contact, student_photo)
    VALUES ('$blood_type', '$department', '$abc_id', '$address', '$father_name', '$mother_name', '$home_contact', '$target_file')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details Form</title>
    <link rel="stylesheet" type="text/css" href="../styles/stud_details.css">
</head>
<body>
    <div class="container">
        <h1>Student Details Form</h1>
        <h3>Welcome <?php echo $name; ?>. Please fill the form</h3>
        <form action="stud_details.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="blood_type">Blood Type:</label><br>
                <select id="blood_type" name="blood_type">
                <option value="">---Select your type---</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="department">Department:</label><br>
                <select id="department" name="department">
                    <option value="">---Select your department---</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Electrical">Electrical</option>
                    <option value="Civil">Civil</option>
                </select>
            </div>
            <div class="form-group">
                <label for="student_photo">Student Photo:</label><br>
                <input type="file" id="student_photo" name="student_photo">
            </div>
            <div class="form-group">
                <label for="abc_id">ABC ID:</label><br>
                <input type="text" id="abc_id" name="abc_id">
            </div>
            <div class="form-group">
                <label for="address">Address:</label><br>
                <input type="text" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name:</label><br>
                <input type="text" id="father_name" name="father_name">
            </div>
            <div class="form-group">
                <label for="mother_name">Mother's Name:</label><br>
                <input type="text" id="mother_name" name="mother_name">
            </div>
            <div class="form-group">
                <label for="home_contact">Home Contact No:</label><br>
                <input type="text" id="home_contact" name="home_contact">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
