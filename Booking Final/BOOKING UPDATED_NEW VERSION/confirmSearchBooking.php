<?php 
session_start();
$date = $_POST['fdate'] ;
include("..\bookingQueries.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Search Booking</title>
</head>
<?php include 'header.php';?>
<body> 
	
	<div class="main">
		<h1  id = "text1" class="fill">Search Booking </h1>
		<div id="enquirytable">
        <table class="view_enquiry">
        <tr>
 	            <th>ID</th>
              <th>Date</th>
              <th>Description</th>
              <th>Action</th>
        </tr>
        <?php
        $result = ViewBookingsFromUser($date);  
        if($result->fetch() ==false){
        ?>
      <tr>
	    <td>No Records</td>
      <td>No Records</td>
      <td>No Records</td>
      <td>No Records</td>7
      </tr>

<?php
        }
        else{
          $userID = 1;
          $i=0; 
          while($row = $result ->fetch()){
           $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row["date"]; ?></td>
            <td><?php echo $row["bookingDesc"]; ?></td>
            <td>
      <form class="edit" method="post" action="confirmAddUserBooking.php" >
      <input type="text" id="userID" name="userID" value="<?php echo $userID?>" hidden />
      <button name="fadd" value = "<?php echo $row["bookingID"];?>" ><i class="fa fa-plus" style="font-size:24px;color:red;"></i></button>
      </form>
    </td>
    <tr>
    <?php
     }
    }
    ?>
    </table>
    <button class="buttonAdvertisements" style="margin-top: 20px"><a href="mainUserBooking.php">Return Back</a></button>
    </div>
    <?php //include 'footer.php';?>
</body>
</html>
