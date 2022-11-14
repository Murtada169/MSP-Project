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
		<h1  id = "text1" class="fill">Add New Appointment</h1>

		<div class="container">
		<form id="form" method="post"  action = confirmAddBooking.php>
				<div class="details">
				<div class="row">
        <div class="col-25">
					<label for="fdate"> Date:  </label>
</div>

<div class="col-75">	
					<input  type="date" id="fdate" name="fdate"  required/>
					
</div>
</div>
					

<div class="row">
        <div class="col-25">
					<label for="ftime"> Time: </label>
</div>

<div class="col-25">
			<select class ="col-25" name="hour" id="hour" required>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
			</select>					<!--<input  type="time" id="ftime" name="ftime"  required/>-->
</div>
<div class="col-25">
			<select class ="col-25" name="mins" id="mins" required>
				<option value="00">00</option>
				<option value="30">30</option>
			</select>					<!--<input  type="time" id="ftime" name="ftime"  required/>-->
</div>
</div>
<div class="row">
        <div class="col-25">
					<label for="fdesc"> Description: * </label>
	</div>

			     <div class="col-75">		
					
					<input id="fdesc" name="fdesc" maxlength=50 type="text" placeholder="Any additional details" required/><br/><br/><br/>
	</div>
	</div>
				</div>

				<div class="rowB">
				<input class="fbutton" id="button1" type="submit" value="Book Appointment"/>
				<button id="button2"><a href="./mainbooking.php">Back to Manage Bookings</a></button>

	</div>

		</form>
	</div>
	</div>
	<?php //include 'footer.php';?>
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




