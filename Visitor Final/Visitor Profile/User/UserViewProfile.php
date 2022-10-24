<?php 
	//session_start();
 ?>
<!DOCTYPE html>
<html>
 
<head>
 	<title>Visitor Profile Page</title>
 	<style>
 		/*.wrapper
 		{
 			width: 300px;
 			margin: 0 auto;
 			color: black;
 		}*/
		
		{
		box-sizing: border-box;
		}

		#profilePageTable{
		/*table-layout:fixed;*/
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #fff;
		font-size: 18px;
		}

		#profilePageTable th, #profilePageTable td {
		/*border: 1px solid #fff;*/
		text-align: center;
		padding: 50px;
		}

		#profilePageTable tr {
		border-bottom: 1px solid #ddd;
		}

		#profileTable1 {
		table-layout: fixed;
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #fff;
		font-size: 18px;
		}

		#profileTable1 th, #profileTable1 td {
		border: 1px solid #fff;
		text-align: left;
		padding: 12px;
		}

		#profileTable1 tr {
		border-bottom: 1px solid #ddd;
		}

		
		#profileTable2 {
		table-layout: fixed;
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #fff;
		font-size: 18px;
		}

		#profileTable2 th, #profileTable2 td {
		
		border: 1px solid #fff;
		text-align: left;
		padding: 12px;
		}

		#profileTable2 tr {
		border-bottom: 1px solid #ddd;
		}

		.editbutton {
		background-color: #4CAF50;
		border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		}

</style>

 	</style>
 </head>
 
 <body style="background-color: #BCD9EC; ">
 	<div class="container">
 		<form action="UserEditProfile.php" method="post">
 			<button class="editbutton" style="float: right; width: 100px;" name="editbutton" type="submit">Edit Profile</button>
 		</form>
 		<div class="wrapper">
 			<?php

			include'../../accountsQueries.php';

			if(isset($_POST['editbutton']))
 			{
 				?>
 				<script type="text/javascript">
 					window.location="UserEditProfile.php"
 				</script>
 				<?php
 			}
			//$query = mysqli_query($db,"SELECT * FROM accounts WHERE accountID = '$accountID'");    
 			?>
 			
            <h2 style="text-align: center;">Visitor Profile Page</h2>
 			
 			<!--<div style="text-align: center;"> <b>Welcome to Cacti-Succulent!</b>
	 			<h4>
	 				<?php //echo $_SESSION['login_user']; ?>
	 			</h4>
 			</div>-->
			<?php
			$result = ViewOwnAccount(100);
			if(mysqli_num_rows($result)>0){
			while($row = $result->fetch_assoc()){
			?>
			 <tab>
			<table id="profilePageTable">
			<b>
				<td>
					<table id='profileTable1'>
						<tr>
							<td>
								<b> First Name: </b>
							</td>

							<td>
								<?php echo $row['fName']?>
							</td>
						</tr>

						<tr>
							<td>
								<b> Last Name: </b>
							</td>
							<td>
								<?php echo $row['lName']?>
							</td>
						</tr>

						<tr>
						<td>
							<b> Date of Birth: </b>
						</td>
						<td>
							<?php echo $row['DOB']?>
						</td>
						</tr>

						<tr>
							<td>
								<b> Email: </b>
							</td>
							<td>
								<?php echo $row['email']?>
							</td>
						</tr>

						<tr>
							<td>
								<b> Username: </b>
							</td>
							<td>
								<?php echo $row['username']?>
							</td>
						</tr>

						<tr>
							<td>
								<b> Password: </b>
							</td>
							<td>
								<?php echo $row['password'] ?>
							</td>
						</tr>

						<tr>
							<td>
								<b> Phone Number: </b>
							</td>
							<td>
								<?php echo $row['phoneNo']?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table id="profileTable2">
						<tr>
							<td>
								<b> Last Visit Date </b>
							</td>
							<td>
							<b>    2022/10/22   </b>
							</td>
						</tr>
					</table>
				</td>
			</b>
			</table>
 			<?php
			}
		}
 			?>
 		</div>
 	</div>
 </body>
 </html>