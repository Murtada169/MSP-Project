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

  // Takes in productID and returns the Product (returns as $result, needs fetch to access)
  function GetItemFromID($productID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Inventory WHERE productID = :productID");
    $stmt->bindParam(":productID", $productID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // Takes in productName, productDesc, productImgName, price and type as parameters and INSERTS into Inventory table
  function AddProduct($productName, $productDesc, $productImgName, $price, $available){
    $stmt = $GLOBALS['conn']->prepare("INSERT into Inventory (productName, productDesc, productImgName, price, available) VALUES (:productName, :productDesc, :productImgName, :price, :available)");
    $stmt->bindParam(":productName", $productName, PDO::PARAM_STR);
    $stmt->bindParam(":productDesc", $productDesc, PDO::PARAM_STR);
    $stmt->bindParam(":productImgName", $productImgName, PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_INT);
    $stmt->bindParam(":available", $available, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }

  // Takes in productName, productDesc, productImgName, price and type as parameters and UPDATES into Inventory table
  function EditProduct($productID, $productName, $productDesc, $productImgName, $price, $available){
    $stmt = $GLOBALS['conn']->prepare("UPDATE Inventory SET productName = :productName, productDesc = :productDesc, productImgName = :productImgName, price = :price, available = :available WHERE productID = :productID;)");
    $stmt->bindParam(":productName", $productName, PDO::PARAM_STR);
    $stmt->bindParam(":productDesc", $productDesc, PDO::PARAM_STR);
    $stmt->bindParam(":productImgName", $productImgName, PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_STR);
    $stmt->bindParam(":available", $available, PDO::PARAM_STR);
    $stmt->bindParam(":productID", $productID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }

  // Takes productID as a parameter and allows changing product from available to unavailable and vice versa
  function ToggleAvailable($productID){
    $stmt = $GLOBALS['conn']->prepare("SELECT available FROM Inventory WHERE productID = :productID);");
    $stmt->bindParam(":productID", $productID, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();
    $available = $result[0];

    if(($available == 0)){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Inventory SET available = 1 WHERE productID = :productID");
      $stmt->bindParam(":productID", $productID, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }else{
      $stmt = $GLOBALS['conn']->prepare("UPDATE Inventory SET available = 0 WHERE productID = :productID");
      $stmt->bindParam(":productID", $productID, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }

    $GLOBALS['conn'] = null;
  }

  function GetProductsFromCart($cart){
    $products = [];
    foreach($cart as $productID => $quantity){
      $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Inventory WHERE productID = :productID");
      $stmt->bindParam(":productID", $productID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      array_push($products, $stmt);
    }
    return $products;
  }
?>
