<?php
  // DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "id19606244_cskadmin";
  $password = "iY5pW(%cpS!]VXy/";
  $dbname = "id19606244_csk";
  $charset = 'utf8mb4';

  try{
    $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // ---------- GENERAL SQL FUNCTIONS ----------

  // Nummber of vistors on a day to day basis
  function NumberOfVisitorsPerDay(){
    $sql = "SELECT COUNT(b.accountID) AS Visitors, CAST(a.date as DATE) AS Date FROM Bookings a JOIN BookingDetails b ON a.bookingID = b.bookingID GROUP BY CAST(a.date as DATE)";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }

  // Which time is most preferred
  function TimeMostPreferred(){
    $sql = "SELECT COUNT(b.accountID) AS Visitors, CAST(a.date as TIME) AS TIME FROM Bookings a JOIN BookingDetails b ON a.bookingID = b.bookingID GROUP BY CAST(a.date as TIME)"
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  // Bookings per visitor
  function BookingsPerVisitor(){
    $sql = "SELECT COUNT(b.accountID) AS Visitors, a.username FROM Accounts a JOIN BookingDetails b ON a.accountID = b.accountID GROUP BY b.accountID";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }
?>
