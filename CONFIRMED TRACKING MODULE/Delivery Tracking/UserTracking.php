<?php
	//session_start();
?>
<!DOCTYPE html>
 <html>
 
 <?php include("header.php")?>

 	<title>Delivery Tracking Status</title>

	<style>
	#usertracking{
	padding: 150px;
	}

	#text1{
	font-family: 'Faustina', serif;
	font-weight: bold;
	font-size: 40px;
	text-align: center;
	}

	#UserTrackingTable {
	margin-left: auto;
	margin-right: auto;
	font-family: 'Faustina', serif;
	/*border-color: #04AA6D;*/
	}


	#UserTrackingTable tr, #UserTrackingTable td{
	padding-right: 50px;
	padding-left: 50px;
	border-style: ridge;
	border-color: #04AA6D;
	/*border: 3px solid;*/
	}

	#UserTrackingTable th{
	font-weight: bold;
	font-size: 20px;
	text-align: center;
	border-left: 2px ridge #04AA6D;
	}

	#UserTrackingTable tr{
	padding-right: 35px;
	padding-left: 35px;
	border-style: ridge;
	border-color: #04AA6D;
	font-weight: lighter;
	font-size: 15px;
	}

	</style>
 
<body>
	<div class="usertracking">
	<br><br><br><br><br>
	<h1 id="text1" style="text-align: center;">Delivery Tracking Status</h1>

	<?php
		
		include'../receiptQueries.php';
        
		$result = GetReceiptsForUser(100);

		
	?>
	
	<table table id='UserTrackingTable'>
		<tr>
			<th>Receipt ID</th>
			<th>Date Purchased</th>
			<th>Date Received</th>
			<th>Amount</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Postcode</th>
			<th colspan='2'>Tracking Status</th>
		</tr>

	<?php
	while($row = $result->fetch()){
		$receiptID = $row['receiptID'];

		echo "<tr>
		<td>".$row['receiptID']."</td>
		<td>".$row['datePurchased']."</td>
		<td>".$row['dateReceived']."</td>
		<td>".$row['amount']."</td>
		<td>".$row['address']."</td>
		<td>".$row['city']."</td>
		<td>".$row['state']."</td>
		<td>".$row['postcode']."</td>
		<td>";
		if($row['cancelled'] == 1){
			echo "Cancelled";
		}else{
			if($row['delivered'] == 0){
				echo "In Delivery";
			}else{
				echo "Delivered";
			}
		}
		echo"</td>
		</tr>";

	}

	?>
	</table>
</div>
<?php //include 'footer.php';?>
</body>
</html>