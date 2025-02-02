<?php
include "../connection.php";
// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $f_id = $_POST["f_id"];
    $dept_code = $_POST["dept_code"];
    $phone_no = $_POST["phone_no"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    
    if ($password != $cpassword) {
        echo "Passwords do not match. Please input the same password.";
        exit();
    }
    
    // Check if roll number or email already exists in the database
    $sql_check = "SELECT * FROM f_signup WHERE f_id='$f_id' OR email='$email'";
    $result_check = mysqli_query($con, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        echo "f_id or email already exists. Please use a different one.";
        exit();
    }
    
    // Insert user data into database
    $sql_insert = "INSERT INTO f_signup (name, email, f_id, dept_code, phone_no, password) VALUES ('$name', '$email', '$f_id', '$dept_code', '$phone_no', '$password')";
    if (mysqli_query($con, $sql_insert)) {
        header("Location: f_login.php");
        exit();
    } else {
        echo "Error: " . $sql_insert . "<br>" . mysqli_error($con);
    }
    
    mysqli_close($con);
    
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="../styles/signup.css">
</head>
<body class="body">

    <div class="login">
        <h1>SIGN UP</h1>
        <form action="f_signup.php" method="post">
            <div class="textbox"><input type="text" placeholder="NAME" name="name"></div>
            <div class="textbox"><input type="email" placeholder="EMAIL ID" name="email"></div>
            <div class="textbox"><input type="f_id" placeholder="FACULTY ID" name="f_id"></div>
            <div class="textbox"><input type="number" placeholder="DEPARTMENT CODE" name="dept_code"></div>
            <div class="textbox"><input type="number" placeholder="PHONE NO." name="phone_no"></div>
            <div class="textbox"><input type="password" placeholder="PASSWORD" name="password"></div>
            <div class="textbox"><input type="cpassword" placeholder="CONFIRM PASSWORD" name="cpassword"></div>
          <div class="sign"><input type="submit" value="SIGN UP" name="submit"></div>
          
        </form>
        <p class="p"> NOW LOGIN : <a href="f_login.php">login</a></p>
    </div>
</body>
</html> 
