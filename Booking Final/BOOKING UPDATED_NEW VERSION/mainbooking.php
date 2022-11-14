<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Booking</title>
  <?php include("..\bookingQueries.php") ?>
</head>
<?php include 'Header.php';?>
<body> 
	<?php include 'navigation.php';?>
	<div class="main">
		<h1  id = "text1" class="fill">Booking Manager </h1>
		<div id="bookingDiv">
			<button type="button" class="buttonAdvertisements" id="addbookingbtn" ><a href = "addbooking.php">Add Booking</a></button>
		</div>
        <div id="enquirytable">
        <table class="view_enquiry">
    <tr >
 	      <th>ID</th>
          <th>Date</th>
          <th>Description</th>
          <th>Booked</th>
          <th>Options</th>
    </tr>
        <?php
     $result = ViewBookingsForAdmin(); 
     $i=0; 
     if (count($result->fetch()) > 0) {  
     while($row = $result->fetch()){
      $i++;
?>
    <tr>
	  <td><?php echo $i; ?></td>
      <td><?php echo $row["date"]; ?></td>
      <td><?php echo $row["bookingDesc"]; ?></td>
      <td><?php echo $row["isBooked"]; ?></td>
      <td>
      <?php
        if($row["isBooked"] ==1){?>
          <form class="view"  method="post" action="viewBooking.php">
          <button name="fview" id ="viewbooking" value = <?php echo $row["bookingID"];?> ><i class="fa fa-eye fa-2x"></i></button>   
          </form>
          <?php
        }
      ?>
      </form>
      <form class="edit" method="post" action="editBooking.php" >
      <button name="fedit" id ="editbooking" value = "<?php echo $row["bookingID"];?>" ><i class="fa fa-edit fa-2x" ></i></button>
      </form>
      <form class="delete"  method="post" action="confirmDeleteBooking.php">
      <button name="fdelete" id ="deletebooking"value = <?php echo $row["bookingID"];?> ><i class="fa fa-trash fa-2x"></i></button>
     
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
    <?php //include 'footer.php';?>
</body>
</html>
