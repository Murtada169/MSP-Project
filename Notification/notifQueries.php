<?php
  // DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $GLOBALS['conn'] = $conn;

  // ---------- GENERAL SQL FUNCTIONS ----------

  // Takes in accountID as parameter and returns all notifications (returns as $result, needs fetch_assoc to access)
  function ViewNotifications($accountID){
    $sql = "SELECT * FROM notifications WHERE accountID = '$accountID' OR accountID = 2";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Takes in subject and notifDesc and INSERTS a global notification
  function AddGlobalNotifications($subject, $notifDesc){
    $sql = "INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (2, '$subject', '$notifDesc', CURRENT_TIMESTAMP, 0);"
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  function isBookingIn30Minutes(){
    // insert code here
  }
?>
