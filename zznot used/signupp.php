<?php
include 'connection.php';
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST" ){        //if($_SERVER["REQUEST_METHOD"] == "POST" ){      if(isset($_POST['submit']))
    $name=$_POST['name'];
    $email= $_POST['email'];
    $reg_no= $_POST['reg_no'];
    $roll_no= $_POST['roll_no'];
    $phone_no= $_POST['phone_no'];
    $password= $_POST['password'];
    $cpassword= $_POST['cpassword'];
    $exist=false;
    if(($password == $cpassword)){
    $sql= "INSERT INTO signup(`name`,`email`,`reg_no`,`roll_no`,`phone_no`,`password`) VALUES('$name','$email','$reg_no','$roll_no','$phone_no','$password')";
    $result = mysqli_query($con, $sql);
    if ($result){
        $showAlert= true;
    }
    else{
        $showError = "passwords do not matchhhh ";    
    }
    header("Location: login.php");
    exit();
    }
    // if(mysqli_query($con,$sql)){
    //     echo "<script>alart('new record inserted')</script>";
    //     echo "<script>window.open('signup.php','_self')</script>";
        
    // }
    // else{
    //     echo "Error:".mysqli_error($con);
    // }
    // mysqli_close($con);
}
?>

  <!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="styles/signup.css">
</head>
<body class="body">
<?php
if($showAlert){
echo "<h3>Your account has been created. please login</h3>";
}
?> 
<?php
if($showError){
echo $showError;
}
?> 

    <div class="login">
        <h1>SIGN UP</h1>
        <form action="signup.php" method="post">
            <div class="textbox"><input type="text" placeholder="NAME" name="name"></div>
            <div class="textbox"><input type="email" placeholder="EMAIL ID" name="email"></div>
            <div class="textbox"><input type="number" placeholder="REGISTRATION NO." name="reg_no"></div>
            <div class="textbox"><input type="number" placeholder="ROLL NO." name="roll_no"></div>
            <div class="textbox"><input type="number" placeholder="PHONE NO." name="phone_no"></div>
            <div class="textbox"><input type="password" placeholder="PASSWORD" name="password"></div>
            <div class="textbox"><input type="cpassword" placeholder="CONFIRM PASSWORD" name="cpassword"></div>
          <div class="sign"><input type="submit" value="SIGN UP" name="submit"></div>
          
        </form>
        <p class="p"> NOW LOGIN : <a href="login.php">login</a></p>
    </div>
</body>
</html> 
