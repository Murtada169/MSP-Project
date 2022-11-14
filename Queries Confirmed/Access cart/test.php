<?php
  session_start();
  $cart = [2 => 3, 3 =>1 , 1 => 4];
  $_SESSION['cart'] = $cart;
  echo "<form method = post action = \"confirm.php\">
          <button type \"submit\">BEGIN TESTING</button>
        </form>";
?>
