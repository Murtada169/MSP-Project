<?php include("..\bookingQueries.php") ?>
<?php
     $userID = 1;
     $result =ViewMyBookings($userID);
     $i = 0;  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Booking</title>

</head>
<?php include 'header.php';?>
<body> 
	<?php //include 'navigation.php';?>
	<div class="main">
		<h1  id = "text1" class="fill">My Current Bookings</h1>
		<div id="bookingDiv">
			<button type="button"  class="buttonAdvertisements" id="searchbookingbtn" ><a href ="searchBooking.php">Search Bookings</a></button>
		</div>
        <div id="enquirytable">
        <table class="view_enquiry">
    <tr>
 	      <th>ID</th>
          <th>Date</th>
          <th>Description</th>
          <th>Options</th>
    </tr>
        <?php
     if ($result->fetch()== false) { ?>
      <tr>
        <td>No Records</td>
        <td>No Records</td>
        <td>No Records</td>
        <td>No Records</td>
      </tr>

     <?php
     }
     else {   
     while($row = $result ->fetch()){
?>
    <tr>
	  <td><?php echo $i; ?></td>
      <td><?php echo $row["date"]; ?></td>
      <td><?php echo $row["bookingDesc"]; ?></td>
      <td>  
      <form class="delete" id ="editbooking" method="post" action="confirmDeleteUserBooking.php">
        <input type="text" id="userID" name="userID" value="<?php echo $userID?>" hidden />
      <button name="fdelete" id ="deletebooking" value = <?php echo $row["bookingID"];?> ><i class="fa fa-trash" style="font-size:24px;color:red;" ></i></button>
      </form>
      </td>
    </tr>
      <?php
      }
    }
    ?>
      </table>
      </div>
    <?php //include 'footer.php';?>
</body>
</html>

