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

// Fetch events from the database
$event_query = "SELECT * FROM events ORDER BY event_date ASC";
$event_result = mysqli_query($con, $event_query);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty</title>
    <link rel="stylesheet" href="../../style_of.css">
</head>
<body>
<nav>
      <div class="logo">
        <img src="../../photos/logo-removebg-preview (1).png" alt="Logo">
      </div>
      <ul class="nav-links">
        <li class="dropdown">
          <a href="#">Home</a>
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

</body>
</html>
    <div class="idp">
    </div>
    <main>
        
        <div class="dist">
            <div class="dist1">
                <!--card section 1-->
                
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Faculty Basic Details</h3>
                      <a href="f_details.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Results</h3>
                      <a href="f_results.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>See CA details</h3>
                      <a href="f_ca2.php" class="btn">Read More</a>
                    </div>
                </div>

            
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>CAs</h3>
                      <a href="f_ca1.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Subject Meterial</h3>
                      <a href="study_mat.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Subject assign</h3>
                      <a href="sub_tag_details.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Student Basic Details</h3>
                      <a href="sss.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Change Password</h3>
                      <a href="f_ch_pass.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Payments</h3>
                      <a href="f_payments.php" class="btn">Read More</a>
                    </div>
                </div>
            </div>
        
            <div class="dist2">
            <h3>Upcoming Events</h3>
            <?php 
            if (mysqli_num_rows($event_result) > 0) {
                while ($event = mysqli_fetch_assoc($event_result)) {
                    echo "<p>" . htmlspecialchars($event['event_name']) . " - " . $event['event_date'] . "</p>";
                }
            } else {
                echo "<p>No upcoming events.</p>";
            }
            ?>
        </div>
            
        </div>
    </div>
    </main>
    <footer>
        <!-- Footer section with contact details -->
        <div class="contact-details">
            <h5><p>&copy ABC Institute of Engineering Techonology</p></h5> <br>
            <h5><p>NH-2, ABC Bypass (N), Kolkata - 700049</p></h5>
            <!-- Add your contact details here -->
        </div>
    </footer>
</body>
</html>