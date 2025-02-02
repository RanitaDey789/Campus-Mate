<?php
    // check session
    session_start();

// Check if user is logged in
if (!isset($_SESSION['roll_no'])) {
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

// Retrieve table name from the form submission
$table_name = $_POST['table_name'];

// Check which CA cards are enabled
$ca1_enabled = isset($_POST['ca1_status']) && $_POST['ca1_status'] == 'enabled';
// Repeat for CA2 and CA3

// Display upload form based on CA card status
?>
    <h1>Student CA Page</h1>
    <?php if ($ca1_enabled): ?>
        <div class="card">
            <h2>CA1</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
                <input type="hidden" name="ca_name" value="CA1">
                <input type="file" name="file">
                <button type="submit" name="submit">Upload File</button>
            </form>
        </div>
    <?php endif; ?>
    <!-- Repeat similar code for CA2 and CA3 -->
</body>
</html>