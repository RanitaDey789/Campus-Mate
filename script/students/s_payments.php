
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/alls.css">
    <title>Student Payment</title>
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
    <?php

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $roll_no = $_SESSION['roll_no'];
        $transaction_id = $_POST['transaction_id'];
        $semester = $_POST['semester'];
        $pay_to_whom = $_POST['pay_to_whom'];
        $date_of_payment = $_POST['date_of_payment'];
        $photo_trans = $_FILES['photo_trans']['name'];
        
        // Get the current timestamp
        $current_timestamp = date('Y-m-d H:i:s');

        // Move uploaded file to a permanent location
        $target_dir = "../../uploads/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES['photo_trans']['name']);
        move_uploaded_file($_FILES['photo_trans']['tmp_name'], $target_file);

        // Get the current year
        $current_year = date('Y');

        // Specify the table name dynamically based on the current year
        $table_name = "payment_stud_$current_year";

        // Construct the CREATE TABLE query
        $query = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            roll_no VARCHAR(20),
            transaction_id VARCHAR(50),
            semester VARCHAR(20),
            pay_to_whom VARCHAR(100),
            date_of_payment DATE,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            photo_trans VARCHAR(100)
        )";
        mysqli_query($con, $query);

        // Insert data into the dynamically created table
        $query = "INSERT INTO $table_name (roll_no, transaction_id, semester, pay_to_whom, date_of_payment, timestamp, photo_trans) VALUES ('$roll_no', '$transaction_id', '$semester', '$pay_to_whom', '$date_of_payment', '$current_timestamp', '$photo_trans')";
        mysqli_query($con, $query);
        header ("Location: student.php");
        echo "<p>Payment details submitted successfully!</p>";
    }
    ?>

    <h2>Submit Payment Details</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="transaction_id">Transaction ID:</label><br>
        <input type="text" id="transaction_id" name="transaction_id" required><br><br>

        <label for="semester">Select Semester:</label><br>
        <select name="semester" id="semester" required>
            <option value='' disabled selected>Select an option</option>
            <option value="semester 1">Semester 1</option>
            <option value="semester 2">Semester 2</option>
            <option value="semester 3">Semester 3</option>
            <option value="semester 4">Semester 4</option>
            <option value="semester 5">Semester 5</option>
            <option value="semester 6">Semester 6</option>
            <option value="semester 7">Semester 7</option>
            <option value="semester 8">Semester 8</option>
        </select><br><br>

        <label for="pay_to_whom">Pay to Whom?</label><br>
        <select name="pay_to_whom" id="pay_to_whom" required>
            <option value='' disabled selected>Select an option</option>
            <option value="Pritam Kumar Dey">Pritam Kumar Dey</option>
            <option value="Sagnik Dutta">Sagnik Dutta</option>
            <option value="Saurav Paul">Sourav Paul</option>
            <option value="Annesha Basak">Annesha Basak</option>
            <option value="Bama Prosad Samanta">Bama Prosad Samanta</option>
            <option value="Accounts Section">Accounts Section</option>
        </select><br><br>

        <label for="date_of_payment">Date of Payment:</label><br>
        <input type="date" id="date_of_payment" name="date_of_payment" required><br><br>

        <label for="photo_trans">Upload Photo of Payment:</label><br>
        <input type="file" id="photo_trans" name="photo_trans" accept="image/*" required><br><br>

        <input type="submit" value="Submit Payment">
    </form>
</body>
</html>
