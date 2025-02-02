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
    </nav>
    <?php
    // Database connection
    include '../connection.php';
    // Start the session to access student's information
    session_start();

    // Check if the student is logged in
    if (!isset($_SESSION['roll_no'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php"); // Change the URL to your login page
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $roll_no = $_SESSION['roll_no'];
        $transaction_id = $_POST['transaction_id'];
        $trans_type = $_POST['trans_type'];
        $photo_trans = $_FILES['photo_trans']['name'];

        // Move uploaded file to a permanent location
        $target_dir = "../../uploads/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES['photo_trans']['name']);
        move_uploaded_file($_FILES['photo_trans']['tmp_name'], $target_file);

        // Insert data into the payment_stud table
        $query = "CREATE TABLE IF NOT EXISTS payment_stud (
            roll_no VARCHAR(20),
            transaction_id VARCHAR(50),
            trans_type VARCHAR(20),
            photo_trans VARCHAR(100)
        )";
        mysqli_query($con, $query);

        $query = "INSERT INTO payment_stud (roll_no, transaction_id, trans_type, photo_trans) VALUES ('$roll_no', '$transaction_id', '$trans_type', '$photo_trans')";
        mysqli_query($con, $query);

        echo "<p>Payment details submitted successfully!</p>";
        header("Location: student.php");
    }
    ?>

    <h2>Submit Payment Details</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="transaction_id">Transaction ID:</label><br>
        <input type="text" id="transaction_id" name="transaction_id" required><br><br>

        <label for="trans_type">Select Transaction Type:</label><br>
        <select name="trans_type" id="trans_type" required>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
            <option value="3">Semester 3</option>
            <option value="4">Semester 4</option>
            <option value="5">Semester 5</option>
            <option value="6">Semester 6</option>
            <option value="7">Semester 7</option>
            <option value="8">Semester 8</option>
        </select><br><br>

        <label for="photo_trans">Upload Photo of Payment:</label><br>
        <input type="file" id="photo_trans" name="photo_trans" accept="image/*" required><br><br>

        <input type="submit" value="Submit Payment">
    </form>
</body>
</html>
