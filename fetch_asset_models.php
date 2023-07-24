<?php
// Establish a connection to the MySQL database
$dbhost = 'localhost';
$dbuser = 'ray'; // Replace with your actual database username
$dbpass = '123'; // Replace with your actual database password
$dbname = 'plexus'; // Replace with your actual database name

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch asset_model values from assetstotal table
$sql = "SELECT DISTINCT asset_model FROM assetstotal";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $assetModels = array();
    while ($row = $result->fetch_assoc()) {
        $assetModels[] = $row;
    }
    echo json_encode($assetModels);
} else {
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
