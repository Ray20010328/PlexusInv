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
            background-color: #d0d0d0; /* Change this to your desired background color */
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            background-color: #d0d0d0;
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
            width: 97%;
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
    <div  >
    <h1 style="padding-top: 15px; "><b>View Records</b></h1>
    <input type="text" id="filterInput" placeholder="Filter by any attribute">
   
    <table id="dataTable">
    <thead>
                <tr>
                    <th onclick="sortTable(0)">Staff Name</th>
                    <th onclick="sortTable(1)">Date</th>
                    <th onclick="sortTable(2)">Site</th>
                    <th onclick="sortTable(3)">Type</th>
                    <th onclick="sortTable(4)">User Name</th>
                    <th onclick="sortTable(5)">Item</th>
                    <th onclick="sortTable(6)">Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
        <tbody>
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
                echo "<td><button class=\"delete-btn\" onclick=\"deleteRecord('" . $row["id"] . "')\">Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }

        // Close the connection
        $conn->close();
        ?>
        </tbody>
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



         // Delete function
         function deleteRecord(recordId) {
            if (confirm("Are you sure you want to delete this record?")) {
                // Send an AJAX request to the server to delete the record
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Refresh the page to update the table after successful deletion
                            location.reload();
                        } else {
                            alert("Failed to delete the record.");
                        }
                    }
                };
                xhr.open("POST", "delete_record.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("recordId=" + encodeURIComponent(recordId));
            }
        }

     // Sorting function
     function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch, direction, switchCount = 0;
            table = document.getElementById("dataTable");
            switching = true;
            // Set the sorting direction to ascending
            direction = "asc";

            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                    if (direction === "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (direction === "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchCount++;
                } else {
                    if (switchCount === 0 && direction === "asc") {
                        direction = "desc";
                        switching = true;
                    }
                }
            }
        }

        
    </script>


<style>


th {
            cursor: pointer;
        }

        th.sort-asc::after {
            content: "\25b2";
            margin-left: 5px;
        }

        th.sort-desc::after {
            content: "\25bc";
            margin-left: 5px;
        }
        /* Additional style for Delete button */
        .delete-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 6px 12px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</body>
</html>