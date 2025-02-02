<?php
include '../connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Loop through each paper to update its status
    foreach ($_POST['papers'] as $paperName => $enabled) {
        // Sanitize the input to prevent SQL injection
        $paperName = $conn->real_escape_string($paperName);
        $enabled = intval($enabled); // Convert to integer (1 or 0)

        // Update the status of the paper in the database
        $sql = "UPDATE papers SET enabled = $enabled WHERE name = '$paperName'";
        $conn->query($sql);
    }

    // Redirect back to the form
    header("Location: index.html");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Submission</title>
    <link rel="stylesheet" href="s_CAs.css">
</head>
<body>
    <div class="container">
        <h1>Paper Submission</h1>
        <form action="submit_papers.php" method="post">
            <label for="ca1">CA1</label>
            <input type="checkbox" id="ca1" name="papers[CA1]" value="1"><br>
            <label for="ca2">CA2</label>
            <input type="checkbox" id="ca2" name="papers[CA2]" value="1"><br>
            <label for="ca3">CA3</label>
            <input type="checkbox" id="ca3" name="papers[CA3]" value="1"><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
