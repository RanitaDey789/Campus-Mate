<?php
session_start();
if (!isset($_SESSION['a_id']) || empty($_SESSION['a_id'])) {
    header("Location: a_login.php");
    exit();
}

include '../connection.php';

$a_id = $_SESSION['a_id'];

$sql = "SELECT a_name FROM admin_master WHERE a_id='$a_id'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['a_name'];
} else {
    $name = "User";
}

// Handle event addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
  $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
  $event_date = mysqli_real_escape_string($con, $_POST['event_date']);
  
  if (!empty($event_name) && !empty($event_date)) {
      $query = "INSERT INTO events (event_name, event_date) VALUES ('$event_name', '$event_date')";
      mysqli_query($con, $query);
  }
}

// Handle event deletion
if (isset($_GET['delete_event'])) {
  $event_id = intval($_GET['delete_event']);
  $delete_query = "DELETE FROM events WHERE id = $event_id";
  mysqli_query($con, $delete_query);
}

// Fetch events
$event_query = "SELECT * FROM events ORDER BY event_date ASC";
$event_result = mysqli_query($con, $event_query);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
     <h3>Welcome <?php echo $name; ?></h3>
    </div>
    </nav>
        <div class="dist">
            <div class="dist1">
                <!--card section 1-->
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Assign Facuty</h3>
                      <a href="f_assign3.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3> Add Table</h3>
                      <a href="add_table.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3> Add Faculty Details</h3>
                      <a href="a_fact_details.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>See Faculty Details</h3>
                      <a href="a_see_fact.php" class="btn">Read More</a>
                    </div>
                </div>
            
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>CAs</h3>
                      <a href="a_ca.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Subject Meterial</h3>
                      <a href="#" class="btn">Read More</a>
                    </div>
                </div> 
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>See Student Details</h3>
                      <a href="a_stud_details.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Fee Structure</h3>
                      <a href="a_fee_str.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Payment</h3>
                      <a href="a_payment_assign.php" class="btn">Read More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="../../photos/download.png" alt="Card Image">
                    <div class="card-content">
                      <h3>Change Password</h3>
                      <a href="a_ch_pass.php" class="btn">Read More</a>
                    </div>
                </div>
            </div>
        
                   <!-- Events Section -->
    <div class="dist2">
        <h3>Upcoming Events</h3>

        <!-- Form to Add Events -->
        <form method="POST" action="">
            <input type="text" name="event_name" placeholder="Event Name" required>
            <input type="date" name="event_date" required>
            <input type="submit" name="add_event" value="Add Event">
        </form>

        <!-- Display Events -->
        <?php while ($event = mysqli_fetch_assoc($event_result)) { ?>
            <div class="event">
                <p><?php echo htmlspecialchars($event['event_name']) . " - " . $event['event_date']; ?></p>
                <a href="?delete_event=<?php echo $event['id']; ?>" class="delete-btn">Delete</a>
            </div>
        <?php } ?>
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