<!DOCTYPE html>
<html lang="en">
<?php include("headerAdmin.php")?>
<body> 
	<?php //include 'navigation.php';
  $result = ViewAdverts();
  $disabled = false;
  
  if(mysqli_num_rows($result) == 5){
    $disabled = true;
  }
  ?>
	<div class="main">
		<h1  id="advertPg" class="fill">Advertisement Manager </h1>
		<div id="bookingDiv">
    <button type="button"  class="buttonAdvertisements" id="addbookingbtn"> <?php if($disabled){echo " Max adverts reached";}else{echo "<a href = \"addadvertworking.php\">Add Advert</a>";}?></button>
		</div>
        <div id="enquirytable">
        <table class="view_enquiry">
    <tr>
          <th>ImageName</th>
          <th>Title</th>
          <th>Description</th>
          <th>Options</th>
    </tr>
        <?php
     
     $i = 0;  
     if (mysqli_num_rows($result) > 0) {  
     while($row = $result->fetch_assoc()){
      $i++;
?>
    <tr>
      <td><?php echo $row["imgName"]; ?></td>
      <td><?php echo $row["title"]; ?></td>
      <td><?php echo $row["advertDesc"]; ?></td>
      <td>
      <form class="edit" method="post" action="editAdvert.php" >
      <button name="fedit" value = "<?php echo $row["advertID"];?>" ><i class="fa fa-edit" style="font-size:24px;color:white;"></i></button>
      </form>
      <form class="delete" id ="deleteadvert" method="post" action="confirmDeleteAdvert.php">
      <button name="fdelete" id ="deletebooking"value = <?php echo $row["advertID"];?> ><i class="fa fa-trash" style="font-size:24px;color:red;" ></i></button>
      </form>
      </td>
    </tr>
      <?php
      }
      }
      else{    
      ?>
      <tr>
      <td>No Records</td>
        <td>No Records</td>
        <td>No Records</td>
        <td>No Records</td>
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
