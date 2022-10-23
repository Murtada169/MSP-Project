<?php
  // DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $GLOBALS['conn'] = $conn;

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all adverts (returns as $result, needs fetch_assoc to access)
  function ViewAdverts(){
    $sql = "SELECT * FROM advertisements";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }
  function GetOneAdvert($advertID){
    $sql = "SELECT * FROM advertisements WHERE advertID = '$advertID'";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }
  // Takes in imgName, title and advertDresc as parameters and INSERTS into Advertisemtns table
  function AddAdverts($imgName, $title, $advertDesc){
    $sql = "INSERT into advertisements (imgName, title, advertDesc) VALUES ('$imgName', '$title', '$advertDesc');
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (2, 'New advertisement alert', '$title', CURRENT_TIMESTAMP, 0);";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  // Takes in advertID, imgName, title and advertDesc as parameters and UPDATES Advertisemtns table
  function EditAdverts($advertID, $imgName, $title, $advertDesc){
    $sql = "UPDATE advertisements SET imgName='$imgName', title='$title', advertDesc='$advertDesc' WHERE advertID = $advertID";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  // Takes in advertID as a parameter and DELETES from Advertisemtns table
  function DeleteAdvert($advertID){
    $sql = "DELETE FROM advertisements WHERE advertID = $advertID";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }
?>
