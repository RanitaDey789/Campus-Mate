<?php
session_start();
if (!isset($_SESSION['roll_no']) || empty($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

include '../connection.php';

$roll_no = $_SESSION['roll_no'];

$sql = "SELECT s_name FROM student_master WHERE roll_no='$roll_no'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['s_name'];
} else {
    $s_name = "User";
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
    <title>Student</title>
    <link rel="stylesheet" href="../../f_style.css">
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
     <h4>Welcome <?php echo $name; ?></h4>
    </div>
    </nav>
        
        <div class="dist">
            <div class="dist1">
                <!--card section 1-->
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Student Basic Details</h3>
                      <a href="student_details.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Class Routine</h3>
                      <a href="#" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Results</h3>
                      <a href="s_results.php" class="btn">Read More</a>
                    </div>
                </div>

            
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>CAs</h3>
                      <a href="s_ca1.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Subject Meterial</h3>
                      <a href="s_study_met.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Payment</h3>
                      <a href="s_payments.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Change Password</h3>
                      <a href="s_ch_pass.php" class="btn">Read More</a>
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