<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

.notification {
  background-color: #555;
  color: white;
  text-decoration: none;
  padding: 15px 26px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification:hover {
  background: red;
}

.notification .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: red;
  color: white;
}
</style>
</head>

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

    $unreadCount = 0;

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            if ($row['isRead']==0){
                $unreadCount++;
            }
        }
    }

    echo "<a href='#' class='notification'>
        <span>Inbox</span>
        <span class='badge'>$unreadCount</span>
    </a>"
?>
</html>