<?php
// Establish a connection to the MySQL database
$dbhost = 'localhost';
$dbuser = 'ray'; // Replace with your actual database username
$dbpass = '123'; // Replace with your actual database password
$dbname = 'plexus'; // Replace with your actual database name

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);



// Check the connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $poNumber = $_POST['po_number'];
    $assetCategory = $_POST['asset_Category'];
    $assetModel = $_POST['asset_model'];
    $assetDescription = $_POST['asset_description'];
    $assetQuantity = $_POST['asset_quantity'];
    $assetLocation = $_POST['asset_location'];
    $assetReceiveDate = $_POST['receive_date'];
    $assetWarrantyDate = $_POST['warranty_date'];

    // Check if the serial number already exists in the table
    $sql = "SELECT * FROM po WHERE po_number = '$poNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Serial number already exists, perform an update
        $sql = "UPDATE po SET asset_category = '$assetCategory', asset_model = '$assetModel', asset_description = '$assetDescription',
                asset_quantity = '$assetQuantity', asset_location = '$assetLocation', asset_receive_date = '$assetReceiveDate',
                asset_warranty_date = '$assetWarrantyDate' WHERE po_number = '$poNumber'";

        if ($conn->query($sql) === TRUE) {
            echo "Asset updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Serial number doesn't exist, perform an insert
        $sql = "INSERT INTO po (po_number, asset_category, asset_model, asset_description,
                asset_quantity, asset_location, asset_receive_date, asset_warranty_date)
                VALUES ('$poNumber', '$assetCategory', '$assetModel', '$assetDescription',
                '$assetQuantity', '$assetLocation', '$assetReceiveDate', '$assetWarrantyDate')";

        if ($conn->query($sql) === TRUE) {
            echo "Asset registered successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }



     // Update the assetstotal table
     $sql = "SELECT * FROM assetstotal WHERE asset_model = '$assetModel' AND site = '$assetLocation'";
     $result = $conn->query($sql);
 
     if ($result->num_rows > 0) {
         // Asset_model and site combination already exists, update the quantity
         $row = $result->fetch_assoc();
         $totalQuantity = $row['quantity'] + $assetQuantity;
 
         $sql = "UPDATE assetstotal SET quantity = '$totalQuantity' WHERE asset_model = '$assetModel' AND site = '$assetLocation'";
         if ($conn->query($sql) !== TRUE) {
             echo "Error updating assetstotal: " . $conn->error;
         }
     } else {
         // Asset_model and site combination doesn't exist, insert a new record
         $sql = "INSERT INTO assetstotal (asset_model, quantity, site) VALUES ('$assetModel', '$assetQuantity', '$assetLocation')";
         if ($conn->query($sql) !== TRUE) {
             echo "Error inserting into assetstotal: " . $conn->error;
         }
     }
 }




// Close the database connection
$conn->close();
?>




