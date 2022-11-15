<!DOCTYPE html>
<html lang="en">
    <!-- <h1>HIIII</h1> -->
<?php
$id=  $_GET['title']; 
?>
  <?php //include("inventoryQueries.php") ?>
  <link href="sanaMainStylesheet.css" rel="stylesheet" />
  <?php include("headerAdmin.php")?>

<?php //include 'navigation.php';
  $result = GetItemFromID($id);
  $i =0;

    while($row = $result->fetch()){
     $i++;
    //  echo $row["productName"];
    //  echo $row["productDesc"];
 

?>
<body> 
<div class="main">
		<h1  id="advertPg" class="fill">Inventory Item:  <?php      echo $row["productName"]; ?>  </h1>
        <div id="editUpdateCardDivOne" style="background-image: linear-gradient(#04AA6D, #b4fde2); width: 700px; float:left; height:350px;  margin:5px">
        <h3 style="  font-family: 'Londrina Shadow', cursive; font-size: 50px; text-align: center;   margin-bottom: 0px;margin-top: 0px; "><?php      echo $row["productName"]; ?></h3>
        <p style="margin: 10px;     font-family: 'Faustina', serif; font-size: 20px;">
        <?php      echo $row["productDesc"]; ?> </p>
        <p style="margin: 10px;  text-align: center  ; font-family: 'Faustina', serif; font-size: 20px;">Price: RM  <?php      echo $row["price"]; ?> </p>
        <!-- <button style="float:right; margin-right: 5px" type="button"  class="buttonAdvertisements" id="addbookingbtn"> <a href="addInventory.php"><?php if($row["available"])  echo "Unavailable ";else echo "Available";?></a></button> -->

</div>
<div id="editUpdateCardDivTwo" style="width: 450px; float:left; height:100px; background:yellow; margin:5px">
<img src="images/<?php      echo $row["productImgName"]; ?>" alt="cactus" width="450" height="350" style=" border: 5px solid #04AA6D;" >
</div>


<div id="bookingDiv">
    <button style="margin-top: 400px;" type="button"  class="buttonAdvertisements" id="addbookingbtn"> <a href="editInventory2.php?title=<?php echo $row['productID']?>">Edit Inventory Item</a></button>
    	
</div>

      


</div>

<?php   }?>
</body>
</html>