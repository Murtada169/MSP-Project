<?php
    // Start the session
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

.isRead{
    display: none;
}

#notificationTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#notificationTable th, #notificationTable td {
  text-align: left;
  padding: 12px;
}

#notificationTable tr {
  border-bottom: 1px solid #ddd;
}

#notificationTable tr.header, #notificationTable tr:hover {
  background-color: #f1f1f1;
}
</style>

<title>Cacti Succulent Kuching</title>
</head>

<body onload='highlightUnread()'>
    <div id="maindiv">
        <!-- will add more selections later -->
        <select id="subjectsSelection" onchange="filterSubject()">
                <option value="">All</option>
                <option value="Upcoming">Upcoming Appointment</option>
                <option value="Advertisement">Advertisement</option>
        </select>
        <?php
            //uncomment the line below on live production
            // $accountID = $_SESSION["accountID"];

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "CSK";

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            // if (!$conn) {
            //     die("Connection failed: " . mysqli_connect_error());
            // }
    
            //uncomment for live production
            // $query = "SELECT * FROM Notifications WHERE accountID = '$accountID' OR accountID = 2 ORDER BY notificationID DESC";
            //uncomment for local testing
            $query = "SELECT * FROM Notifications ORDER BY notificationID DESC";

            $result = mysqli_query($conn, $query);

            echo "<table id='notificationTable'>";
            echo "<tr class='header'>
                    <th>Date</th>
                    <th>Subject</th>
                    <th>Content</th>
                </tr>";
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>". $row['date'] . "</td><td>". $row['subject'] . "</td><td>" . $row['notifDesc'] . "</td><td class='isRead'>" . $row['isRead'] . "</td></tr>";
                }
            }else {
                echo "0 results";
            }
            echo "</table>";

            mysqli_close($conn);
        ?>
    </div>

    <script>
        function highlightUnread(){
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("subjectsSelection");
            filter = input.value.toUpperCase();
            table = document.getElementById("notificationTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue == 0) {
                        tr[i].style.backgroundColor="#00FF00";
                    } else {
                        tr[i].style.backgroundColor = "";
                    }
                }
            }
        }

        function filterSubject() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("subjectsSelection");
            filter = input.value.toUpperCase();
            table = document.getElementById("notificationTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>
</html>