<?php
$servername="localhost";
$username="root";
$password="";
$database="bbs";
$con=mysqli_connect($servername,$username,$password,$database);
//$con=mysqli_connect("localhost","root","","signup");
if(!$con){
    die("error detected".mysqli_error($con));
}
else{
    // echo"Welcome";
}
?>