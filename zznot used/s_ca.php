<!DOCTYPE html>
<html>
<head>
    <title>Upload Sections</title>
    <link rel="stylesheet" href="../styles/s_caStyle.css">
</head>
<body>
    <div class="container">
        <h2>Upload Sections</h2>
        <?php
        // Connect to the database
        include '../connection.php';

        // Function to get the status of a section
        function getSectionStatus($sectionName, $con) {
            $sql = "SELECT status FROM castatus WHERE branch='$sectionName'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['status'];
            }
            return 'disabled'; // Default to disabled if not found
        }

        // Check the status of each section before allowing access
        $CA1_status = getSectionStatus("CA1", $con);
        $CA2_status = getSectionStatus("CA2", $con);
        $CA3_status = getSectionStatus("CA3", $con);

        // Display upload sections based on status
        function displaySection($sectionName, $status) {
            echo '<div class="section';
            if ($status === 'disabled') {
                echo ' disabled';
            }
            echo '">';
            echo '<h3>' . $sectionName . '</h3>';
            if ($status === 'enabled') {
                echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
                echo '<input type="file" name="' . $sectionName . '_file" id="' . $sectionName . '_file">';
                echo '<input type="submit" value="Upload" name="submit">';
                echo '</form>';
            } else {
                echo '<p>Section ' . $sectionName . ' is disabled.</p>';
            }
            echo '</div>';
        }

        displaySection("CA1", $CA1_status);
        displaySection("CA2", $CA2_status);
        displaySection("CA3", $CA3_status);

        $con->close();
        ?>
    </div>
</body>
</html>
