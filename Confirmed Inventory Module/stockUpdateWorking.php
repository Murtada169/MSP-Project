<?php
    include("inventoryQueries.php");
    ToggleAvailable($_POST['id']);
    header("Location: mainInventory.php");
?>