<!DOCTYPE html>
<html lang="en">

<?php include("headerAdmin.php")?>

<body> 
	<?php //include 'inventoryQueries.php';
  $result = ViewInventory();
  $i =0;
  

  ?>
		<div class="main">
		<h1  id="advertPg" class="fill">Inventory Items Manager </h1>
		<div id="bookingDiv">
    <button type="button"  class="buttonAdvertisements" id="addbookingbtn"> <a href="addInventory.php">Add Inventory Item</a></button>
		</div>
        <div id="enquirytable">
        <table class="view_enquiry">
    <tr>
          <th>All Plants</th>
          <th>Current Stock Status</th>
          <th>Update Stock Status</th>
          
    </tr>
        <?php
     
     $i = 0;  
     if (count($result->fetch()) > 0) {  
     while($row = $result->fetch()){
      $i++;
?>
    <tr>
      <td>   <a href="editUpdateInventory.php?title=<?php echo $row['productID']?> "><?php echo $row["productName"]; ?></a></td>
      <td>  <?php if($row["available"]) echo "Available"; else echo "Unavailable" ?> </td>
      <td><form id="form" method="post"  action = "stockUpdateWorking.php" enctype="multipart/form-data">
        <input type = "hidden" name = "id" value = <?php echo $row['productID']?>></input>
        <button type="submit" style="background-color:#FFFFFF;"  ><i class="fa fa-refresh fa-2x"  aria-hidden="true"></i></button>
     </form></td>
      
    </tr>
      <?php
      }
      }
      else{    
      ?>
      <tr>
      <td>No Records</td>
      </tr>
      <?php }?>
      </table>
      </div>
    <?php//include 'footer.php';?>
</body>

</html>

<script>

</script>
