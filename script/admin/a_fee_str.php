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
    <link rel="stylesheet" href="../styles/design.css">
    <title>Admin Fees Structure</title>
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
    <?php

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $course_name = $_POST['course_name'];
        $fees_amount = $_POST['fees_amount'];

        // Get the current year
        $current_year = date('Y');

        // Specify the table name dynamically based on the current year
        $table_name = "fees_structure_$current_year";

        // Construct the CREATE TABLE query
        $query = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            course_name VARCHAR(100) NOT NULL,
            fees_amount DECIMAL(10,2) NOT NULL
        )";
        mysqli_query($con, $query);

        // Insert data into the dynamically created table
        $query = "INSERT INTO $table_name (course_name, fees_amount) VALUES ('$course_name', '$fees_amount')";
        mysqli_query($con, $query);

        echo "<p>Fees structure submitted successfully!</p>";
    }

    // Display the form for adding fees structure
    echo "<h2>Add Fees Structure</h2>";
    echo "<form method='post'>";
    echo "<label for='course_name'>Course Name:</label><br>";
    echo "<input type='text' id='course_name' name='course_name' required><br><br>";
    echo "<label for='fees_amount'>Fees Amount:</label><br>";
    echo "<input type='number' step='0.01' id='fees_amount' name='fees_amount' required><br><br>";
    echo "<input type='submit' value='Submit'>";
    echo "</form>";

    // Display the table details to the admin
    try{echo "<h2>Fees Structure Table Details</h2>";
    echo "<p>Table Name: $table_name</p>";

    // Retrieve and display table data
    $query = "SELECT * FROM $table_name";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Course Name</th><th>Fees Amount</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['course_name'] . "</td>";
            echo "<td>" . $row['fees_amount'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No fees structure data available.</p>";
    }
}
catch (mysqli_sql_exception $e){
    Echo "<h3>No fee structure data available for now.</h3>";
}
    ?>
</body>
</html>
