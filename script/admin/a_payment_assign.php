<?php
    session_start();
    // Check if user is logged in
    if (!isset($_SESSION['a_id'])) {
    header("Location: a_login.php"); // Redirect to login page if not logged in
    exit();
    }
    // Connect to database (replace with your database credentials)
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty to Payment Names</title>
    <link rel="stylesheet" href="../styles/alls.css">
</head>
<body>
<nav>
      <div class="logo">
        <img src="../../photos/logo-removebg-preview (1).png" alt="Logo">
      </div>
      <ul class="nav-links">
        <li class="dropdown">
          <a href="admin.php">Home</a>
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
    </nav> <br><br>
    <h2>Add Faculty to Payment Names</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php

        // Fetch faculty names from faculty_master table
        $query = "SELECT f_id, f_name FROM faculty_master";
        $result = $con->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<input type='checkbox' name='faculty[]' value='" . $row['f_id'] . "'>" . $row['f_name'] . "<br>";
            }
        }
        ?>
        <br>
        <input type="checkbox" id="accounts_section" name="accounts_section" value="1">
        <label for="accounts_section">Accounts Section</label><br><br>
        <input type="submit" name="submit" value="Add Faculty">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process selected faculty names
        $faculty = $_POST['faculty'] ?? [];
        $accounts_section = isset($_POST['accounts_section']) ? 1 : 0;

        // Insert faculty names into payment_names table
        foreach ($faculty as $f_id) {
            $f_id = intval($f_id);
            if ($f_id == 0) {
                $f_name = 'Accounts Section';
            } else {
                // Fetch faculty name from faculty_master table
                $query = "SELECT f_name FROM faculty_master WHERE f_id = $f_id";
                $result = $con->query($query);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $f_name = $row['f_name'];
                }
            }

            // Insert into payment_names table
            $stmt = $con->prepare("INSERT INTO payment_names (f_id, f_name) VALUES (?, ?)");
            $stmt->bind_param("is", $f_id, $f_name);
            $stmt->execute();
        }

        echo "Faculty added successfully!";
    }
    // Show contents of payment_names table
    echo "<h3>Payment Names Table</h3>";
    $query = "SELECT * FROM payment_names";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>F_ID</th><th>F_Name</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['f_id'] . "</td><td>" . $row['f_name'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No records found in the payment_names table.";
    }
    ?>
</body>
</html>
