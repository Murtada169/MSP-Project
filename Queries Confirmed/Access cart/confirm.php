<?php
  session_start();
  $cart = $_SESSION['cart'];
  include('inventoryQueries.php');
  $products = GetProductsFromCart($cart);

  foreach($products as $result){
    while($row = $result->fetch()){ // DO NOT CHANGE, for fetching multiple data/columns/both
      echo "<p> " . $row["productName"] . "</p>";
      echo "<p> " . $row["price"] . "</p>";
    }
  }

  session_destroy();
?>
