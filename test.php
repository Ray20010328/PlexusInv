<?php
echo "11111111111111111111111111";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Check if the form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    echo "2222222222222222222222";
    // Get form data
    $staffName = $_POST["sname"];
    $deployDate = $_POST["deploy_date"];
    $site = $_POST["site"];
    $deploymentType = $_POST["Type"];
    $userName = $_POST["uname"];
    $item = $_POST["Item"];
    $itemQuantity = $_POST["item_quantity"];

    // Database connection details
    $servername = "localhost";
    $username = "ray";
    $password = "123";
    $dbname = "plexus";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    echo "1333333333333333333333331";
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Connected ffffffffffffffff";
    }


echo "Connected successfully";

    // Prepare and execute the SQL query to insert data into the table
    $sql = "INSERT INTO staff_deployments (staff_name, deploy_date, site, deployment_type, user_name, item, item_quantity)
            VALUES ('$staffName', '$deployDate', '$site', '$deploymentType', '$userName', '$item', $itemQuantity)";

    // Check if the query was successful
    if ($conn->query($sql) === TRUE) {
        header("Location: deploy.html?message=success");
        exit();
    } else {
        header("Location: deploy.html?message=failed");
        exit();
    }

    // Close the connection
    $conn->close();
}
?>

