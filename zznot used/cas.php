<?php
    // check session
    session_start();

// Check if user is logged in
if (!isset($_SESSION['f_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
    // database connection
    include '../connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Study Material</title>
    <link rel="stylesheet" href="../styles/all.css">
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
    </nav>
    <?php
// Generate a unique table name
$table_name = "ca_" . uniqid();

// Create the table
$sql = "CREATE TABLE $table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ca_name VARCHAR(30) NOT NULL,
    status VARCHAR(10) NOT NULL
)";

if ($con->query($sql) === FALSE) {
    echo "Error creating table: " . $con->error;
}

// Close the connection
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty CA Page</title>
</head>
<body>
    <h1>Faculty CA Page</h1>
    <div class="card">
        <h2>CA1</h2>
        <form action="s_ca.php" method="post">
            <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
            <button type="submit" name="ca1_status" value="enabled">Enable</button>
            <button type="submit" name="ca1_status" value="disabled">Disable</button>
        </form>
    </div>
    <div class="card">
        <h2>CA2</h2>
        <form action="s_ca.php" method="post">
            <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
            <button type="submit" name="ca2_status" value="enabled">Enable</button>
            <button type="submit" name="ca2_status" value="disabled">Disable</button>
        </form>
    </div>
    <div class="card">
        <h2>CA3</h2>
        <form action="s_ca.php" method="post">
            <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
            <button type="submit" name="ca3_status" value="enabled">Enable</button>
            <button type="submit" name="ca3_status" value="disabled">Disable</button>
        </form>
    </div>
    <!-- Repeat similar code for CA2 and CA3 -->
</body>
</html>

</body>
</html>