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

  // Takes in accountID as parameter and returns all Notifications (returns as $result, needs fetch_assoc to access)
  function ViewNotifications($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Notifications WHERE accountID = :accountID OR accountID = 2");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Takes in subject and notifDesc and INSERTS a global notification
  function AddGlobalNotifications($subject, $notifDesc){
    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (2, ':subject', ':notifDesc', CURRENT_TIMESTAMP, 0);");
    $stmt->bindParam(":subject", $subject, PDO::PARAM_INT);
    $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
  }

?>
