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
    <title>Upload Study Material</title>
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
    <h2>Upload Study Material</h2>
    <form class="form" action="" method="post" enctype="multipart/form-data">
    <label for="dept_name">Department:</label>
        <select name="dept_name" id="dept_name">
            <option value='' disabled selected>---Select a department---</option>
            <option value="CSE">CSE</option>
            <option value="EE">EE</option>
            <option value="ECE">ECE</option>
            <option value="ME">ME</option>
            <option value="CE">CE</option>
        </select>
        <label for="sub_code">Subject:</label>
        <select name="sub_code" id="sub_code">
        <option value='' disabled selected>---Select a Subject---</option>

            <?php
            // Retrieve subjects assigned to the faculty
            $faculty_id = $_SESSION['f_id'];
            $subject_query = "SELECT sub_code FROM assign_fact2 WHERE f_id = $faculty_id";
            $result = $con->query($subject_query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['sub_code'] . "'>" . $row['sub_code'] . "</option>";
                }
            } else {
                echo "<option value=''>No subjects assigned</option>";
            }
            
        echo '</select><br><br>';
        echo'<label for="file">Select File:</label>';
        echo'<input type="file" name="file" id="file"><br><br>';
        echo'<input type="submit" value="Upload" name="submit">';
        echo'</form>';
    if(isset($_POST['submit'])) {
                // Database connection parameters
                include '../connection.php';
        
                // Handle file upload
                $department = $_POST['dept_name'];
                $subject = $_POST['sub_code'];
                $file_name = $_FILES['file']['name'];
                $file_tmp = $_FILES['file']['tmp_name'];
        
                // Check if faculty is assigned to the subject
                $faculty_id = $_SESSION['f_id'];
                $check_query = "SELECT * FROM assign_fact2 WHERE f_id = $faculty_id AND sub_code = '$subject'";
                $result = $con->query($check_query);
                if ($result->num_rows == 0) {
                    echo "You are not assigned to upload materials for this subject.";
                    exit();
                }
        
                // Move uploaded file to desired directory
                $upload_dir = "../../uploads/";
                move_uploaded_file($file_tmp, $upload_dir.$file_name);
        
                // Insert data into database
                $sql = "INSERT INTO study_mat (dept_name, subject, file_name) VALUES ('$department', '$subject', '$file_name')";
                if ($con->query($sql) === TRUE) {
                    echo "Study material uploaded successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            }
            
            $query = "SELECT sub_dept FROM assign_fact2 WHERE f_id = '$faculty_id'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $dept = $row['sub_dept'];

        $query = "SELECT study_mat.* FROM study_mat
        INNER JOIN subject_master ON study_mat.subject = subject_master.sub_code
        WHERE subject_master.sub_dept_name = '$dept'";
        $result = mysqli_query($con, $query);
        $con->close();
            ?>
    <h2>Study Material</h2>
    <?php
        // $query = "SELECT sub_dept FROM assign_fact2 WHERE f_id = '$faculty_id'";
        // $result = mysqli_query($con, $query);
        // $row = mysqli_fetch_assoc($result);
        // $dept_name = $row['dept_name'];

        // $query = "SELECT study_mat.* FROM study_mat
        // INNER JOIN subject_master ON study_mat.subject = subject_master.sub_code
        // WHERE subject_master.sub_dept_name = '$dept_name'";
        // $result = mysqli_query($con, $query);
    ?>
    <table>
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Material</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['subject']; ?></td>
                <td><a href="../../uploads/<?php echo $row['file_name']; ?>" target="_blank">View Material For The Subject</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
