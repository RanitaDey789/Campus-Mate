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

if (isset($_POST['submit'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['error'] == 0 && !empty($file)) {
        // Open the CSV file
        $handle = fopen($file, "r");

        // Get the header row (column names)
        $columns = fgetcsv($handle);

        // Create a table in BBS database with the column names
        $createTableQuery = "CREATE TABLE IF NOT EXISTS csv_data (" . implode(" VARCHAR(255), ", $columns) . " VARCHAR(255))";
        if (mysqli_query($con, $createTableQuery)) {
            echo "Table created successfully or already exists.<br>";
        } else {
            echo "Error creating table: " . mysqli_error($con) . "<br>";
        }

        // Insert data into the table
        while (($data = fgetcsv($handle)) !== FALSE) {
            $insertQuery = "INSERT INTO csv_data (" . implode(", ", $columns) . ") VALUES ('" . implode("', '", $data) . "')";
            if (mysqli_query($con, $insertQuery)) {
                echo "Record inserted successfully.<br>";
            } else {
                echo "Error inserting record: " . mysqli_error($con) . "<br>";
            }
        }

        fclose($handle);
    } else {
        echo "Please upload a valid CSV file.<br>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV File</title>
</head>
<body>
    <h2>Welcome, <?php echo $name; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit" name="submit">Upload CSV</button>
    </form>
</body>
</html>
