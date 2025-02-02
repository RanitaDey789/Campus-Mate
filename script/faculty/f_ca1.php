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
    <title>Toggle Buttons</title>
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

// Function to update CA_id in the database
function updateCA($con, $ca_id) {
    $sql = "UPDATE CA_id SET enabled = 0";
    $con->query($sql);
    
    $sql = "UPDATE CA_id SET enabled = 1 WHERE id = $ca_id";
    $con->query($sql);
}

// If a toggle button is clicked, update the database
if (isset($_POST['submit'])) {
    $ca_id = $_POST['ca_id'];
    updateCA($con, $ca_id);
}

// Fetch the current enabled CA
$sql = "SELECT * FROM CA_id WHERE enabled = 1";
$result = $con->query($sql);
$current_enabled_ca = 0; // Default value
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_enabled_ca = $row['id'];
}

$con->close();
?>
<?php
$button_texts = array("Enable CA1", "Enable CA2", "Enable CA3");
foreach(range(1, 3) as $ca_index) {
    $button_text = $button_texts[$ca_index - 1];
    if($current_enabled_ca == $ca_index) {
        $button_text = "Disable CA" . $ca_index;
    }
?>
    <form method="post">
        <input type="submit" name="submit" value="<?php echo $button_text; ?>">
        <input type="hidden" name="ca_id" value="<?php echo $ca_index; ?>" <?php if($current_enabled_ca == $ca_index) echo 'checked="checked"'; ?>>
    </form>
<?php } ?>

<?php
if(isset($_POST['submit'])) {
    $ca_id = $_POST['ca_id'];
    if($current_enabled_ca == $ca_id) {
        $button_text = "Enable CA" . $ca_id;
        $current_enabled_ca = 0; // Disabling all
    } else {
        $button_text = "Disable CA" . $ca_id;
        $current_enabled_ca = $ca_id; // Enabling selected
    }
}
?>
</html>
