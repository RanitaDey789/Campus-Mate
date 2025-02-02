<?php
session_start();
if (!isset($_SESSION['roll_no']) || empty($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

include '../connection.php';

$roll_no = $_SESSION['roll_no'];

$sql = "SELECT s_name FROM student_master WHERE roll_no='$roll_no'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['s_name'];
} else {
    $s_name = "User";
}
// Fetch the enabled CA
$sql = "SELECT * FROM CA_id WHERE enabled = 1";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$current_enabled_ca_id = $row['id'];
$current_enabled_ca_name = "CA" . $current_enabled_ca_id;

// Get ca, semester, year, and subject code
$semester = isset($_POST['semester']) ? $_POST['semester'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$subject_code = isset($_POST['subject_code']) ? $_POST['subject_code'] : '';
// Display roll number for debugging
//echo "Session Roll No: " . $_SESSION['roll_no'] . "<br>";

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all necessary fields are provided
    if ($semester && $year && $subject_code && isset($_FILES["fileToUpload"])) {
        $table_name = $current_enabled_ca_name . "_" . $subject_code . "_" . $semester . "_" . $year;

        // Create table if not exists
        $sql_create_table = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            roll_no BIGINT NOT NULL,
            file_name VARCHAR(255) NOT NULL
        )";
        if ($con->query($sql_create_table) === FALSE) {
            echo "Error creating table: " . $con->error;
        } else {
            // File upload handling
            $target_dir = "../../uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


            // Allow certain file formats
            if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
                echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } 
            
            else {
                //$roll_no = $_SESSION['roll_no']; // using for debigging
                //echo "Roll No: " . $roll_no . "<br>";
                $roll_no = $_SESSION['roll_no'];
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // Insert file details into the table
                    $sql_insert_file = "INSERT INTO $table_name (roll_no, file_name) VALUES ('$roll_no', '" . basename( $_FILES["fileToUpload"]["name"]) . "')";
                    if ($con->query($sql_insert_file) === TRUE) {
                        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    } else {
                        echo "Error: " . $sql_insert_file . "<br>" . $con->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    } else {
        echo "Please provide all necessary details.";
    }
}

// Fetch uploaded files for the specific CA, semester, year, and current user
//$roll_no = $_SESSION['roll_no'];
if ($semester && $year && $subject_code) {
    $table_name = "CA_" . $subject_code . "_" . $semester . "_" . $year;
    $sql_fetch_files = "SELECT * FROM $table_name WHERE roll_no = $roll_no";
    $result_files = $con->query($sql_fetch_files);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/alls.css">
    <title>Upload CA</title>
</head>
<body>
<nav>
      <div class="logo">
        <img src="../../photos/logo-removebg-preview (1).png" alt="Logo">
      </div>
      <ul class="nav-links">
        <li class="dropdown">
          <a href="student.php">Home</a>
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
     <h4>Welcome <?php echo $name; ?></h4>
    </div>
    </nav>
    <br><br>
    <h2>Upload <?php echo $current_enabled_ca_name; ?></h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      
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
        </select> <br><br>
        <input type="file" name="fileToUpload" id="fileToUpload"> <br><br>
        <input type="submit" value="Upload CA" name="submit">
    </form>
    <?php
    // Fetch all uploaded files for the specific student

    // $roll_no = $_SESSION['roll_no'];
    // $sql_fetch_files = "SELECT * FROM $table_name WHERE roll_no = $roll_no";
    // $result_files = $con->query($sql_fetch_files);
    // if ($result_files->num_rows > 0) {
    //     echo "<h3>Uploaded Files</h3>";
    //     echo "<table border='1'>";
    //     echo "<tr><th>File Name</th><th>Download</th></tr>";
    //     while($row = $result_files->fetch_assoc()) {
    //         echo "<tr>";
    //         echo "<td>" . $row['file_name'] . "</td>";
    //         echo "<td><a href='../../uploads/" . $crow['file_name'] . "' download>Download</a></td>";
    //         echo "</tr>";
    //     }
    //     echo "</table>";
    // } else {
    //     echo "<p>No files uploaded yet.</p>";
    // }

    $con->close();
    ?>
</body>
</html>
