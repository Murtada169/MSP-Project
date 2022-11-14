<?php
  // DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";
  $charset = 'utf8mb4';

  try{
    $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all Receipts (returns as $result, needs fetch to access)
  function GetAllReceipts(){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Receipts");
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // Takes in receiptID as a parameter and returns Receipt (returns as $result, needs fetch to access)
  function GetReceipt($receiptID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Receipts WHERE receiptID = :receiptID");
    $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // Takes in accountID, amount and datePurchased as parameters and INSERTS into Receipts table
  function AddReceipt($accountID, $cart, $amount, $address, $city, $state, $postcode){
    $stmt = $GLOBALS['conn']->prepare("INSERT into Receipts (accountID, datePurchased, amount, address, city, state, postcode)
            VALUES (:accountID, CURRENT_TIMESTAMP, :amount, :address, :city, :state, :postcode);");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->bindParam(":amount", $amount, PDO::PARAM_INT);
    $stmt->bindParam(":address", $address, PDO::PARAM_STR);
    $stmt->bindParam(":city", $city, PDO::PARAM_STR);
    $stmt->bindParam(":state", $state, PDO::PARAM_STR);
    $stmt->bindParam(":postcode", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("SELECT MAX(receiptID) from Receipts;");
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    $recieptID = $result[0];

    foreach($cart as $productID => $quantity){
      $stmt = $GLOBALS['conn']->prepare("INSERT into ItemSold VALUES (:receiptID, :productID, :quantity)");
      $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_INT);
      $stmt->bindParam(":productID", $productID, PDO::PARAM_STR);
      $stmt->bindParam(":quantity", $quantity, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
            VALUES (:accountID, 'Order Made', :notifDesc, CURRENT_TIMESTAMP)");
    $notifDesc = "Your item(s) have been placed to order! Please pay at your next visit/COD. Receipt ID: ".$receiptID;
    $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }

  // Takes in receiptID as a parameter and allows updating receipt as delivered
  function ToggleDelivered($receiptID){
    $stmt = $GLOBALS['conn']->prepare("SELECT delivered FROM Receipts WHERE receiptID = :receiptID);");
    $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    $delivered = $result[0];

    if(($delivered == 0)){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Receipt SET delivered = 1 WHERE receiptID = :receiptID");
      $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);

      $stmt = $GLOBALS['conn']->prepare("SELECT accountID FROM Receipt WHERE receiptID = :receiptID");
      $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $result = $stmt->fetch();
      $accountID = $result[0];

      $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
              VALUES (:accountID, 'Item(s) Delivered', :notifDesc, CURRENT_TIMESTAMP)");
      $notifDesc = "Your item(s) have been delivered! Receipt ID: ".$receiptID;
      $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
      $stmt->bindParam(":accountID", $accountID, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }

    $GLOBALS['conn'] = null;
  }

  // Takes in receiptID as a parameter and allows updating receipt as cancelled
  function ToggleCancelled($receiptID){
    $stmt = $GLOBALS['conn']->prepare("SELECT cancelled FROM Receipts WHERE receiptID = :receiptID);");
    $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    $cancelled = $result[0];

    if(($cancelled == 0)){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Receipt SET cancelled = 1 WHERE receiptID = :receiptID");
      $stmt->bindParam(":cancelled", $cancelled, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);

      $stmt = $GLOBALS['conn']->prepare("SELECT accountID FROM Receipt WHERE receiptID = :receiptID");
      $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $result = $stmt->fetch();
      $accountID = $result[0];
      
      $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
              VALUES (:accountID, 'Order cancelled', :notifDesc, CURRENT_TIMESTAMP)");
      $notifDesc = "Your item(s) have been cancelled by the administrator. Please contact them for more details. Receipt ID: ".$receiptID;
      $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
      $stmt->bindParam(":accountID", $accountID, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }

    $GLOBALS['conn'] = null;
  }

  // Takes in receiptID as a paremeter and returns the total amount
  function GetTotalAmount($receiptID){
    $stmt = $GLOBALS['conn']->prepare("SELECT SUM(b.price * a.quantity) as total FROM inventory b JOIN itemsold a ON b.productID = a.productID where a.receiptID = :receiptID");
    $stmt->bindParam(":receiptID", $receiptID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    return $result[0];
  }

  // ---------- USER SQL FUNCTIONS ----------

  // Takes in acocuntID as a paremeter and returns all Receipts  (returns as $result, needs fetch to access)
  function GetReceiptsForUser($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Receipts WHERE accountID = :accountID");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }
?>
