<?php
// Database connection details
$servername = "localhost";
$username = "ray";
$password = "123";
$dbname = "plexus";

// Get the record ID to be deleted from the AJAX request
if (isset($_POST["recordId"])) {
    $recordId = $_POST["recordId"];

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to delete the record from the table
    $sql = "DELETE FROM staff_deployments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recordId);

    if ($stmt->execute()) {
        // Deletion was successful
        echo "success";
    } else {
        // Deletion failed
        echo "failed";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
