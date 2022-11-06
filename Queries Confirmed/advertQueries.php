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

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all adverts (returns as $result, needs fetch_assoc to access)
  function ViewAdverts(){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Advertisements");
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  function GetOneAdvert($advertID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Advertisements WHERE advertID = :advertID");
    $stmt->bindParam(":advertID", $advertID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // Takes in imgName, title and advertDresc as parameters and INSERTS into Advertisemtns table
  function AddAdverts($imgName, $title, $advertDesc){
    $stmt = $GLOBALS['conn']->prepare("INSERT into Advertisements (imgName, title, advertDesc)
            VALUES (:imgName, :title, :advertDesc);
            INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (2, 'New advertisement alert', :title, CURRENT_TIMESTAMP, 0);");
    $stmt->bindParam(":imgName", $imgName, PDO::PARAM_STR);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":advertDesc", $advertDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }

  // Takes in advertID, imgName, title and advertDesc as parameters and UPDATES Advertisemtns table
  function EditAdvertDetails($advertID, $title, $advertDesc){
    $stmt = $GLOBALS['conn']->prepare("UPDATE Advertisements SET title=:title, advertDesc=:advertDesc WHERE advertID = :advertID");
    $stmt->bindParam(":imgName", $imgName, PDO::PARAM_STR);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":advertDesc", $advertDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }

  function EditAdvertImageAndDetails($advertID, $imgName, $title, $advertDesc){
    $stmt = $GLOBALS['conn']->prepare("UPDATE Advertisements SET imgName = :imgName, title=:title, advertDesc=:advertDesc WHERE advertID = :advertID");
    $stmt->bindParam(":advertID", $advertID, PDO::PARAM_STR);
    $stmt->bindParam(":imgName", $imgName, PDO::PARAM_STR);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":advertDesc", $advertDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }


  // Takes in advertID as a parameter and DELETES from Advertisemtns table
  function DeleteAdvert($advertID){
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM Advertisements WHERE advertID = :advertID");
    $stmt->bindParam(":advertID", $advertID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }
?>
