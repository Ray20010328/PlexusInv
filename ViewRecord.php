<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <!-- Add any CSS styles here -->
     <!-- basic -->
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
 
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #filterInput {
            margin: 10px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<header>
        <!-- header inner -->
        <div class="header">

            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                        <div class="full">
                            <div class="center-desk">
                                <div class="logo">
                                    <a href="main.html"><img src="images/plexusimage.png" alt="#"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                        <div class="menu-area">
                            <div class="limit-box">
                                <nav class="main-menu"> 
                                    <ul class="menu-area-main">
                                        <!--class = active to change to active page-->
                                        <li> <a href="register.html">Register Asset</a> </li>
                                        <li > <a href="Deploy.html">Deploy</a> </li>
                                        <li ><a href="Receive.html">Receive</a></li>
                                        <li class="active"><a href="ViewRecord.php">View Record</a></li>
                                        <li><a href="Alert.html">Alert</a></li>
                                        <li class="last">
                                            <a href="login.html">Login</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- end header -->
    </header>
    <div class="div-1">
    <h1>View Records</h1>
    <input type="text" id="filterInput" placeholder="Filter by any attribute">
   
    <table id="dataTable">
        <tr>
            <th>Staff Name</th>
            <th>Date</th>
            <th>Site</th>
            <th>Type</th>
            <th>User Name</th>
            <th>Item</th>
            <th>Quantity</th>
        </tr>
        <?php
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

        // Fetch records from the database
        $sql = "SELECT * FROM staff_deployments";
        $result = $conn->query($sql);

        // Display records in the table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["staff_name"] . "</td>";
                echo "<td>" . $row["deploy_date"] . "</td>";
                echo "<td>" . $row["site"] . "</td>";
                echo "<td>" . $row["deployment_type"] . "</td>";
                echo "<td>" . $row["user_name"] . "</td>";
                echo "<td>" . $row["item"] . "</td>";
                echo "<td>" . $row["item_quantity"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }

        // Close the connection
        $conn->close();
        ?>
    </table>
   
    </div>
    <script>
        // Filter function
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("filterInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        // Attach event listener to the filter input
        document.getElementById("filterInput").addEventListener("keyup", filterTable);
    </script>
</body>
</html>