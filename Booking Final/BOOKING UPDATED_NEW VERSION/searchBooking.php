<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Search Booking</title>
  <?php include("..\bookingQueries.php") ?>
</head>
<?php include 'header.php';?>
<body> 

	<div class="main">
		<h1  id = "text1" class="fill">Search Booking </h1>
		<form id="form" method="post"  action = confirmSearchBooking.php>
			
				<div class="details">
					<label for="fdate"> Date: * </label><input  type="date" id="fdate" name="fdate"  required/>
          			<input class="fbutton" type="submit" value="Search"/>
				</div>
		
		</form>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br>
    <?php include 'footer.php';?>
</body>
</html>


<script>
  $(document).ready(
	function() {
  		var today = new Date().toISOString().split('T')[0];
  		$("#fdate").attr('min', today);
	}
	
)

;
</script>

