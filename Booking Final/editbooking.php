<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Booking</title>
  <?php include("..\bookingQueries.php") ?>
</head>
<?php
	session_start();
	$row= $_POST['fedit'] ;
	$result = GetOneBooking($row);
	while($row = $result->fetch_assoc()){
	$datetime = $row["date"];
	$bookingID = $row["bookingID"];
	$date_arr= explode(" ", $datetime);
	$date= $date_arr[0];
	$time= $date_arr[1];
	$desc = $row["bookingDesc"];
	}
?> 
<?php include 'Header.php';?>   
<body>
	<?php include 'navigation.php';?>	
	<div class="main">
		<h1  id = "text1" class="fill">Edit Appointment</h1>
		<div class="container">
		<form id="form" method="post" action = confirmEditBooking.php>
		
				<div class="details">
				<div class="row">
        <div class="col-25">
					<label for="fdate"> Date: * </label>
</div>
<div class="col-75">	
					<input  type="date" id="fdate" name="fdate" value ="<?php echo $date?>" required/><br/><br/><br/>
</div>
</div>	
<div class="row">
        <div class="col-25">
					<label for="ftime"> Time:* </label>
</div>
<div class="col-75">	
					<input  type="time" id="ftime" name="ftime"  value ="<?php echo $time?>" required/><br/><br/><br/>
</div>
</div>
					
<div class="row">
        <div class="col-25">
					<label for="fdesc"> Description: * </label>
</div>
<div class="col-75">	
					<input id="fdesc" name="fdesc"  value ="<?php echo $desc?>" maxlength=50 type="text" placeholder="Any additional details" required/><br/><br/><br/>
</div>
<!-- <div class="row">
        <div class="col-25">
					<label for="id"> Booking ID * </label>
</div> -->
<div class="col-75">
	<!-- HIDDEN DATA BEING PASSED -->
					<input  hidden type="number" id="id" name="id"  value ="<?php echo $bookingID?>"><br/><br/><br/>
</div>
				</div>
				<div class="rowB">
				<input class="fbutton" id="button1"  type="submit" value="Update Enquiry"/>
</div>
		</form>
</div>
	</div>
	<?php// include 'footer.php';?>
</body>

<script>
	
  $(document).ready(
	function() {
  		var today = new Date().toISOString().split('T')[0];
  		$("#fdate").attr('min', today);
	}
	
)

;
</script>




