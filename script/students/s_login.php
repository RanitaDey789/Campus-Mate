<?php
include '../connection.php';
if(isset($_POST['submit'])){
// Get form data
$roll_no = $_POST['roll_no'];
$password = $_POST['password'];

// Check if roll number exists in the database
$sql_check = "SELECT * FROM student_master WHERE roll_no='$roll_no'";
$result_check = mysqli_query($con, $sql_check);
if (mysqli_num_rows($result_check) == 0) {
    header("Location: s_login.php?error=not_exist");
    exit();
}

// Verify password
// $row = mysqli_fetch_assoc($result_check);
// if ($password != $row['password']) {
//     echo "<h3>Incorrect password. Please try again.</h3>";
//     exit();
// }
$row = mysqli_fetch_assoc($result_check);
    $hashed_password = $row['password'];

    // Check if password matches hashed password
    if(password_verify($password, $hashed_password)) {
        // Password matches hashed password
        session_start();
        $_SESSION['roll_no'] = $row['roll_no'];
        $_SESSION['s_name'] = $row['s_name'];
        header("Location: student.php");
        exit();
    } elseif($password == $row['password']) {
        // Password matches non-hashed password
        session_start();
        $_SESSION['roll_no'] = $row['roll_no'];
        $_SESSION['s_name'] = $row['s_name'];
        header("Location: student.php");
        exit();
    } else {
        // Neither hashed nor non-hashed password matches
        echo "<h3>Incorrect password. Please try again.</h3>";
        exit();
    }
}

mysqli_close($con);
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
        <form action="s_login.php" method="post">
        <div class="textbox"><input type="number" placeholder="ROLL NO." name="roll_no" required></div>
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