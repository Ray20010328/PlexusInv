<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Check if the form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    
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
   
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
       
    }


echo "Connected successfully";

    // Prepare and execute the SQL query to insert data into the table
    $sql = "INSERT INTO staff_deployments (staff_name, deploy_date, site, deployment_type, user_name, item, item_quantity)
            VALUES ('$staffName', '$deployDate', '$site', '$deploymentType', '$userName', '$item', $itemQuantity)";

    // Check if the query was successful
    if ($conn->query($sql) === TRUE) {
        // If the deployment type is "Receive," add the quantity to the assetstotal table
        if ($deploymentType === "Receive") {
            $sql = "INSERT INTO assetstotal (asset_model, quantity, site)
                    VALUES ('$item', $itemQuantity, '$site')
                    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        } else if ($deploymentType === "Deploy") {
            // If the deployment type is "Deploy," subtract the quantity from the assetstotal table
            $sql = "UPDATE assetstotal 
                    SET quantity = quantity - $itemQuantity 
                    WHERE asset_model = '$item' AND site = '$site'";
        }

        if ($conn->query($sql) === TRUE) {
            header("Location: receive.html?message=success");
            exit();
        } else {
            header("Location: receive.html?message=failed");
            exit();
        }
    } else {
        header("Location: receive.html?message=failed");
        exit();
    }



    // Close the connection
    $conn->close();
}
?>