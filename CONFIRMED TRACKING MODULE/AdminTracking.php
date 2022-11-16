<?php
	//session_start();
?>
<!DOCTYPE html>
 <html>
 
 
<?php include("header.php")?>

 	<title>Visitor Profile Page</title>

	<style>
		#admintracking{
		padding: 150px;
		}

		#text1{
		font-family: 'Faustina', serif;
		font-weight: bold;
		font-size: 40px;
		text-align: center;
		}

		/* fieldset{
		padding: 5px;
		border-width: 1px;

		} */

		#AdminTrackingTable {
		margin-left: auto;
		margin-right: auto;
		font-family: 'Faustina', serif;
		/*border-color: #04AA6D;*/
		padding: 50px;
		}


		#AdminTrackingTable tr, #AdminTrackingTable td{
		padding-right: 50px;
		padding-left: 50px;
		border-style: ridge;
		border-color: #04AA6D;
		/*border: 3px solid;*/
		}

		#AdminTrackingTable th{
		font-weight: bold;
		font-size: 20px;
		text-align: center;
		border-left: 2px ridge #04AA6D;
		}

		#AdminTrackingTable tr{
		padding-right: 35px;
		padding-left: 35px;
		border-style: ridge;
		border-color: #04AA6D;
		font-weight: lighter;
		font-size: 15px;
		}

		/*#deletebooking i{
		color: red;
		} 
		#deletebooking{
		background-color: white;
		color: red;
		
		}

		#editbooking{
		background-color: white;
		color: green;
		
		}*/

		button{
		border: none;
		background-color: none;
		z-index: 1;
		}

		/*.editbutton {
		float: left;

		}
		.delete {
		float: right;
		}*/

		.deliverbutton {
		margin-bottom: 20px;
		display: block;
		margin-left: auto;
		margin-right: auto;

		background-color: #04AA6D; /* Green */
		border: 2px solid #04AA6D;
		color: black;
		padding: 15px 32px;
		
		transition-duration: 0.4s;
		cursor: pointer;
		}
		.deliverbutton a{
		text-align: center;
		text-decoration: none;
		color: black;
		
		font-size: 16px;
		margin: 4px 2px;
		} 
		.deliverbutton:hover {
		background-color: white;
		color: black;
		}

		.cancelbutton {
		margin-bottom: 20px;
		display: block;
		margin-left: auto;
		margin-right: auto;

		background-color: #04AA6D; /* Green */
		border: 2px solid #04AA6D;
		color: black;
		padding: 15px 32px;
		
		transition-duration: 0.4s;
		cursor: pointer;
		}
		.cancelbutton a{
		text-align: center;
		text-decoration: none;
		color: black;
		
		font-size: 16px;
		margin: 4px 2px;
		} 
		.cancelbutton:hover {
		background-color: white;
		color: black;
		}
	</style>
 
 
<body>
	<div class="admintracking">
	<br><br><br><br><br>
	<h1 id="text1" style="text-align: center;">Delivery Tracking Status</h1>

	<!--<select id="subjectsSelection" onchange="filterSubject()">
                <option value="">All</option>
                <option value="In Delivery">In Delivery</option>
                <option value="Delivered">Delivered</option>
				<option value="Cancelled">Cancelled</option>
        </select>
	
	<input type="text" id="myInput" onkeyup="myFunction()" 
	placeholder="Search for names.." title="Type in a name">-->
	
	<?php
		
		include'receiptQueries.php';
        
		if(isset ($_POST['deliverbutton'])){
			ToggleDelivered($_POST['deliverbutton']);
		}
		
		if(isset ($_POST['cancelbutton'])){
			ToggleCancelled($_POST['cancelbutton']);
		}

		$result = GetAllReceipts();

		
	?>
	
	<table table id='AdminTrackingTable'>
		<tr>
			<th>Receipt ID</th>
			<th>Date Purchased</th>
			<th>Date Received</th>
			<th>Amount</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Postcode</th>
			<th>Tracking Status</th>
			<th colspan = '2'>Update Tracking Status</th>
		</tr>

	<?php
   
	while($row = $result->fetch()){
		$receiptID = $row['receiptID'];

		/*echo "<tr>
		<td>".$row['receiptID']."</td>
		<td>".$row['accountID']."</td>
		<td>".$row['productID']."</td>
		<td>".$row['datePurchased']."</td>
		<td>".$row['dateReceived']."</td>
		<td>".$row['amount']."</td>
		<td>".$row['address']."</td>
		<td>".$row['city']."</td>
		<td>".$row['state']."</td>
		<td>".$row['postcode']."</td>
		<td class='delivered'>".$row['delivered']."</td>
		<td class='cancelled'>".$row['cancelled']."</td>
		
		<td>
		<form action='AdminTrackingProcess.php' method='post'>
				<br>
					<select name='status' class='form-control' id='phoneno'>
						<option value='select'>Select Tracking Status</option>
                        <option value='delivered'>Delivered</option>
						<option value='cancelled'>Cancelled</option>
					</select>

                    <div style='padding-left 100px;'>
					    <button class='savebutton' type='submit' name='savebutton' 
					    style='left' value='Submit'>Save</button>
				    </div>
	    </form>
		</td>
		</tr>
		";*/
		/*<td>".GetTotalAmount($receiptID)."</td>*/

		echo "<tr>
		<td>".$row['receiptID']."</td>
		<td>".$row['datePurchased']."</td>
		<td>".$row['dateReceived']."</td>
		<td>";
		echo GetTotalAmount($receiptID);
		echo"</td>
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
		<td>
		<form action='AdminTracking.php' method='post'>
			<button class='deliverbutton' name='deliverbutton' value=$receiptID type='submit'>Delivered</button>
	    </form>
		</td>
		<td>
		<form action='AdminTracking.php' method='post'>
			<button class='cancelbutton' name='cancelbutton' value=$receiptID type='submit'>Cancelled</button>
	    </form>
		</td>
		</tr>";

	}
	?>
	</table>  

</div> 

<!--<script>
 function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("AdminTrackingTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>-->

<?php //include 'footer.php';?>
</body>
</html>