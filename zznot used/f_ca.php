<?php
// Connect to the database
include'../connection.php';

// Function to enable or disable a section
function toggleSectionStatus($sectionName, $status) {
    global $con;
    $sql = "UPDATE castatus SET status='$status' WHERE branch='$sectionName'";
    $con->query($sql);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enable_ca1'])) {
        toggleSectionStatus("CA1", "enabled");
    } elseif (isset($_POST['disable_ca1'])) {
        toggleSectionStatus("CA1", "disabled");
    }
    
    if (isset($_POST['enable_ca2'])) {
        toggleSectionStatus("CA2", "enabled");
    } elseif (isset($_POST['disable_ca2'])) {
        toggleSectionStatus("CA2", "disabled");
    }
    
    if (isset($_POST['enable_ca3'])) {
        toggleSectionStatus("CA3", "enabled");
    } elseif (isset($_POST['disable_ca3'])) {
        toggleSectionStatus("CA3", "disabled");
    }
}

$con->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enable/Disable Sections</title>
    <link rel="stylesheet" href="../styles/f_ca.css">
</head>
<body>
    <h2>Enable/Disable Sections</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="branch">Select Branch:</label>
                <select id="branch" name="branch">
                <option value="CS">---SELECT BRANCH---</option>
                <option value="CS">Computer Science (CS)</option>
                <option value="ECE">Electronics and Communication (ECE)</option>
                <option value="EE">Electrical Engineering (EE)</option>
            </select>    

        <h3>CA1</h3>
        <input type="submit" name="enable_ca1" value="Enable CA1">
        <input type="submit" name="disable_ca1" value="Disable CA1">
        <h3>CA2</h3>
        <input type="submit" name="enable_ca2" value="Enable CA2">
        <input type="submit" name="disable_ca2" value="Disable CA2">
        <h3>CA3</h3>
        <input type="submit" name="enable_ca3" value="Enable CA3">
        <input type="submit" name="disable_ca3" value="Disable CA3">
    </form>
</body>
</html>
