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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/alls.css">
    <title>Faculty Payments</title>
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
    <?php

    // Retrieve faculty's ID
    $f_id = $_SESSION['f_id'];

    // Retrieve faculty's name from faculty_master table
    $query = "SELECT f_name FROM faculty_master WHERE f_id = '$f_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $f_name = $row['f_name'];

    // Get the current year
    $current_year = date('Y');

    // Construct the table name dynamically based on the current year
    $table_name = "payment_stud_$current_year";

    // Retrieve payment data where pay_to_whom matches faculty's name
    $query = "SELECT * FROM $table_name WHERE pay_to_whom = '$f_name'";
    $result = mysqli_query($con, $query);

    // Display payment data in a table with checkboxes
    echo "<h2>Faculty Payments</h2>";
    echo "<form method='post'>";
    echo "<table border='1'>";
    echo "<tr><th>Select</th><th>Roll No</th><th>Transaction ID</th><th>Semester</th><th>Pay to Whom</th><th>Date of Payment</th><th>Timestamp</th><th>Photo</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><input type='checkbox' name='selected_payments[]' value='" . $row['id'] . "'></td>";
        echo "<td>" . $row['roll_no'] . "</td>";
        echo "<td>" . $row['transaction_id'] . "</td>";
        echo "<td>" . $row['semester'] . "</td>";
        echo "<td>" . $row['pay_to_whom'] . "</td>";
        echo "<td>" . $row['date_of_payment'] . "</td>";
        echo "<td>" . $row['timestamp'] . "</td>";
        echo "<td><img src='../../uploads/" . $row['photo_trans'] . "' width='100' height='100'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit' name='submit' value='Go'>";
    echo "</form>";

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve selected payment IDs
        if (isset($_POST['selected_payments'])) {
            $selected_payments = $_POST['selected_payments'];

            // Create a new table dynamically with faculty's ID
            $new_table_name = "payment_faculty_$f_id";

            // Construct the CREATE TABLE query
            $query = "CREATE TABLE IF NOT EXISTS $new_table_name (
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

            // Insert selected payment data into the dynamically created table
            foreach ($selected_payments as $payment_id) {
                $query = "INSERT INTO $new_table_name (roll_no, transaction_id, semester, pay_to_whom, date_of_payment, photo_trans) SELECT roll_no, transaction_id, semester, pay_to_whom, date_of_payment, photo_trans FROM $table_name WHERE id = $payment_id";
                mysqli_query($con, $query);
            }

            echo "<p>Data stored successfully in table $new_table_name.</p>";
        } else {
            echo "<p>No payments selected.</p>";
        }
    }
    ?>

</body>
</html>
