<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body class="body">
  <div class="login">

    <h1>LOG IN</h1>
    <form action="login.php" method="post">
      <div class="textbox"><input type="text" placeholder="MAIL ID" name="email" required></div>
      <div class="textbox"><input type="password" placeholder="PASSWORD" name="password"  required></div>
      <div><input type="submit" value="LOGIN" name="submit"></div>
    </form>
    <p class="not">not a user ? <a href="signup.php">sign up</a> </p>
  </div>
</body>
</html>
<?php
include 'connection.php';
if(isset($_POST['submit'])){
  $email=$_POST['email'];
  $password=$_POST['password'];
  $sql="SELECT * FROM signup WHERE email='$email' and password='$password'";
  //$que=mysqli_query($con,$sql);
  $res=$con->query($sql);
  //if(mysqli_num_rows($que)>0){
    if(mysqli_num_rows($res)>0){
    while($row=$res->fetch_assoc()){
      echo "hi ".$row["name"]." you are loged in";
    } 
    echo "<script>alert('loged in')</script>";
    //echo "<script>window.open('students/student.php','_self')</script>";
  }
  else{
    echo"<script>alert(Wrong info)</script>";
  }
}
?>