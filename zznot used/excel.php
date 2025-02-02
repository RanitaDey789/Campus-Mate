<!DOCTYPE html>
<html>
<head>
    <title>Excel to HTML Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Upload Excel File</h2>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="excel_file" />
    <input type="submit" value="Upload" />
</form>

<?php
// Check if a file is uploaded
if(isset($_FILES['excel_file'])) {
    // Include the PHPExcel library
    require 'PHPExcel/Classes/PHPExcel.php';

    // Get the uploaded file
    $file = $_FILES['excel_file']['tmp_name'];

    // Load the Excel file
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    // Get the first sheet
    $sheet = $objPHPExcel->getActiveSheet();

    // Get the highest row number and column letter
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    // Display the table header
    echo "<h2>Data from Excel File</h2>";
    echo "<table>";
    echo "<tr>";
    for ($col = 'A'; $col <= $highestColumn; $col++) {
        echo "<th>" . $sheet->getCell($col . '1')->getValue() . "</th>";
    }
    echo "</tr>";

    // Loop through each row of the sheet
    for ($row = 2; $row <= $highestRow; $row++) {
        echo "<tr>";
        // Loop through each column of the row
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            // Get the cell value
            $value = $sheet->getCell($col . $row)->getValue();
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>

</body>
</html>
