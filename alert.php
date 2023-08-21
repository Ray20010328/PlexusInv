    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- mobile metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!-- site metas -->
        <title>Plexus Inventory</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- style css -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Responsive-->
        <link rel="stylesheet" href="css/responsive.css">
        <!-- fevicon -->
        <link rel="icon" href="images/fevicon.png" type="image/gif" />
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    
        <style>
            /* Add styles for the grey background container */
            .grey-container12345 {
                background-color: #f2f2f2;
                padding: 50px 0;
            }

            table {
                border-collapse: collapse;
                margin: 20px auto;
                width: 50%;
            }

            th,
            td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>
    <body> 
        <!-- header -->
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
                                            <li class="active"> 
                                            <li> <a href="register.html">Register Asset</a> </li>
                                            <li> <a href="Deploy.html">Deploy</a> </li>
                                            <li><a href="Receive.html">Receive</a></li>
                                            <li><a href="ViewRecord.php">View Record</a></li>
                                            <li><a href="alert.php">Alert</a></li>
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
        <body>
        <!-- Add the grey background container -->
        <div class="grey-container12345">
        <h1 style="text-align: center;">Assets Total Table</h1>

            <!-- Add a search input field -->
            <div class="121212"   style="text-align: center;">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search" placeholder="">
            </div>

            
            

    
        

    

    <table id="assetTable">
            <tr>
                <th>Asset Model</th>
                <th>Site</th>
                <th>Quantity</th>
            </tr>
            <?php
        // Replace these with your actual database credentials
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

        // SQL query to fetch data from the assetstotal table
        $sql = "SELECT asset_model, site, quantity FROM assetstotal";

        // Execute the query and get the result
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display data in a table
        

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["asset_model"] . "</td>
                        <td>" . $row["site"] . "</td>
                        <td>" . $row["quantity"] . "</td>
                    </tr>";
            }
            
        } else {
            echo "0 results";
        }

        // Close the connection
        $conn->close();
        ?>
    </table>
            <script>
                // Add event listener to the search input field
                document.getElementById("search").addEventListener("keyup", function () {
                    // Get the search keyword entered by the user
                    var searchKeyword = this.value.toLowerCase();

                    // Get all the rows in the table
                    var rows = document.getElementById("assetTable").getElementsByTagName("tr");

                    // Loop through the rows and hide/show them based on the search keyword
                    for (var i = 1; i < rows.length; i++) { // Start at index 1 to skip the table header row
                        var rowData = rows[i].getElementsByTagName("td");
                        var showRow = false;

                        // Check if the search keyword matches any of the columns (asset model, site, or quantity)
                        for (var j = 0; j < rowData.length; j++) {
                            var cellData = rowData[j].innerText.toLowerCase();
                            if (cellData.indexOf(searchKeyword) > -1) {
                                showRow = true;
                                break;
                            }
                        }

                        // Show or hide the row based on the search result
                        rows[i].style.display = showRow ? "" : "none";
                    }
                });
            </script>

</div>
    </body>
   
    </html>
