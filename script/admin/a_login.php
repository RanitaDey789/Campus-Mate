<?php
include '../connection.php';
if(isset($_POST['submit'])){
// Get form data
$a_id = $_POST['a_id'];
$password = $_POST['password'];

// Check if roll number exists in the database
$sql_check = "SELECT * FROM admin_master WHERE a_id='$a_id'";
$result_check = mysqli_query($con, $sql_check);
if (mysqli_num_rows($result_check) == 0) {
    header("Location: a_login.php?error=not_exist");
    exit();
}

// Verify password
$row = mysqli_fetch_assoc($result_check);
if ($password != $row['password']) {
    echo "<h3>Incorrect password. Please try again.</h3>";
    exit();
}

// Start session and store user information
session_start();
$_SESSION['a_id'] = $row['a_id'];
$_SESSION['name'] = $row['name'];

// Redirect to student page
header("Location: admin.php");
exit();

mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../styles/login_s.css">
</head>
<body class="body">
<div class="main">
    <div class="login">
        <h1>LOG IN</h1>
        <?php
        if(isset($_GET['error']) && $_GET['error'] == 'not_exist') {
            echo "<p>User does not exist. Please sign up first.</p>";
        }?>
        <form action="a_login.php" method="post">
      <div class="textbox"><input type="number" placeholder="ADMIN ID" name="a_id" required></div>
      <div class="textbox"><input type="password" placeholder="PASSWORD" name="password"  required></div>
        <div><input type="submit" value="LOGIN" name="submit"></div>
        </form>
        <p class="not">not a user ? <a href="s_signup.php">sign up</a> </p>
    </div>
    <div class="imgg">
        <img src="../../photos/ciet.webp" alt="photo">
    </div>
</div>
</body>
</html>