<?php
// Establish a connection to the MySQL database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'plexus'; // Replace with your actual database name

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $emailAddress = $_POST['email_address'];
    $username = $_POST['username_account'];
    $password = $_POST['confirm_Password'];
    $userSite = $_POST['user_Site'];
    $phoneNumber = $_POST['phone_Number'];

    // Check if the serial number already exists in the table
    $sql = "SELECT * FROM loginAcc WHERE email_address = 'emailAddress'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Serial number already exists, perform an update
        $sql = "UPDATE loginAcc SET username_account = '$username', confirm_Password = '$password', user_Site = '$userSite', phone_Number = '$phoneNumber' WHERE email_address = '$emailAddress'";

        if ($conn->query($sql) === TRUE) {
            echo "Asset updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Serial number doesn't exist, perform an insert
        $sql = "INSERT INTO loginAcc (email_address, username_account, confirm_Password)
                VALUES ('$emailAddress', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Asset registered successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
