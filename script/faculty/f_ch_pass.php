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
    <link rel="stylesheet" type="text/css" href="../styles/alls.css">
    <title>Change Password</title>
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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate form inputs
        // You can add more validation rules as per your requirements
        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            echo "<p>Please fill in all fields.</p>";
        } elseif ($new_password !== $confirm_password) {
            echo "<p>New password and confirm password do not match.</p>";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Retrieve the current user's ID from session
            $f_id = $_SESSION['f_id'];

            // Check if the old password matches the current password in the database
            $query = "SELECT password FROM faculty_master WHERE f_id = '$f_id'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            if ($row && $old_password === $row['password']) {
                // Update the password in the database
                $update_query = "UPDATE faculty_master SET password = '$hashed_password' WHERE f_id = '$f_id'";
                mysqli_query($con, $update_query);
                echo "<p>Password updated successfully!</p>";
            } else {
                echo "<p>Incorrect old password.</p>";
            }
        }
    }
    ?>

    <h2>Change Password</h2>
    <form method="post">
        <label for="old_password">Old Password:</label><br>
        <input type="password" id="old_password" name="old_password" required><br><br>

        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>

        <label for="confirm_password">Confirm New Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="Change Password">
    </form>
</body>
</html>
