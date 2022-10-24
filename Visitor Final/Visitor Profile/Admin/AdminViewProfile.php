<?php
	//session_start();
?>
<!DOCTYPE html>
 <html>
 
 <head>
 	<title>Visitor Profile Page</title>

	<style>
		* {
		box-sizing: border-box;
		}

		#profileTableAdminView {
		border-collapse: collapse;
		width: 100%;
		border: 1px solid #ddd;
		font-size: 18px;
		}

		#profileTableAdminView th, #profileTableAdminView td {
		text-align: left;
		padding: 12px;
		}

		#profileTableAdminView tr {
		border-bottom: 1px solid #ddd;
		}

		#profileTableAdminView tr.header, #profileTableAdminView tr:hover {
		background-color: #f1f1f1;
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
 </head>
 
<body>
	<?php
		
		include'../../accountsQueries.php';
        
		$result = ViewAllAccounts();

		
	?>
	
	<table table id='profileTableAdminView'>
		<tr>
			<th>Account ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Date of Birth</th>
			<th>Email</th>
			<th>Username</th>
			<th>Phone Number</th>
		</tr>

	<?php
	while($row = mysqli_fetch_assoc($result)){
		$accountID = $row['accountID'];
		echo "<tr>
		<td>".$row['accountID']."</td>
		<td>".$row['fname']."</td>
		<td>".$row['lname']."</td>
		<td>".$row['DOB']."</td>
		<td>".$row['email']."</td>
		<td>".$row['username']."</td>
		<td>".$row['phoneno']."</td>
		<td>
		<form action='AdminEditProfile.php' method='post'>
		<button class='editbutton' style='float: right; width: 100px;' name='editbutton' value=$accountID type='submit'>Edit Profile</button>
	    </form>
		</td>
		</tr>";
	}
	?>
	</table>
</body>

