<?php
	//session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Visitor Profile Settings</title>
	<style>
		*{
		box-sizing:border-box;
		color:black;
		}
		
		/* Form Css*/
		#form{
			padding:10px;
			width:80%;
			display: inline-block;
			margin:0px 90px;
		}

		fieldset{
		padding: 10px;
		border-width: 10px;

		}

		legend, legend h1{
		text-align:center;
		color:#0073cf;

		}

		.formdetails{
			margin:10px;
			text-align: center;

		}

		form label{
			color:#000000;
			width:20%;
			padding-bottom: 50px;

		}
		form option,select {
			
			color:#32CD32;
			text-align: center;
			width:80%;
		}
		form select,option,textarea{
			color:black;
		}

		input{
			padding:5px;
			color:#000000;
			width:60%;
			border-style: groove;
			border-width: 5px;
			border-radius: 70px;
			border-color:  black;
			text-align: center;	
			
		}

		#form .savebutton{
			text-align:center;
			background-color:#32CD32;
			color:#000;
			padding:10px;
			margin-left:10px;

		}

		.savebutton {
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

		#form .fbutton:hover{
			transition: all 0.9s ease 0.1s; 
			color:#FFFFFF;
		}
	</style>
</head>
<body style="background-color: #BCD9EC;">


	<h2 style="text-align: center;color: #000000;">Edit Information</h2>

	<?php

        include'../../accountsQueries.php';
        
        $result = DisplayAccountDetails($_POST['editbutton']);
        $row = mysqli_fetch_assoc($result);

		
		/*$query = mysqli_query($db,"UPDATE accounts SET fname='$fname', lname='$lname' , DOB='$DOB', email='$email',
        username='$username', oassword='$password', phoneno='$phoneno' WHERE accountID = $accountID;
        INSERT into notifications (accountID, subject, notifDesc, date, isRead)
        VALUES ('$accountID', 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);";

        $sql = "UPDATE accounts SET fname='$fname', lname='$lname' , DOB='$DOB', email='$email',
            username='$username', oassword='$password', phoneno='$phoneno' WHERE accountID = $accountID;
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
            VALUES ('$accountID', 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);";*/
        
        //$query = mysqli_query($db,"SELECT * FROM accounts WHERE accountID = '$accountID'");

		//while ($row = mysqli_fetch_assoc($result)) 
		//{
			$accountID=$row['accountID'];
			$fname=$row['fname'];
			$lname=$row['lname'];
            $DOB=$row['DOB'];
            $email=$row['email'];
			$username=$row['username'];
			$phoneno=$row['phoneno'];
		//}

	?>

	<!--<div class="profile_info" style="text-align: center;">
		<span style="color: white;">Welcome,</span>	
		<h4 style="color: white;"></h4>
	</div><br><br>-->
	
	<fieldset>
		<legend><h1 class="form">Personal Details</h1></legend>
		<div class="formdetails">
			<form if='form' action="AdminEditProfileProcess.php" method="post">

			<label><h4><b>Account ID: </b></h4></label>
			<input class="form-control" type="text" name="accountID"  value="<?php echo $accountID; ?>">

			<label><h4><b>First Name: </b></h4></label>
			<input class="form-control" type="text" name="fname"  value="<?php echo $fname; ?>">

			<label><h4><b>Last Name: </b></h4></label>
			<input class="form-control" type="text" name="lname" value="<?php echo $lname; ?>">

			<label><h4><b>Date of Birth: </b></h4></label>
			<input class="form-control" type="text" name="DOB" value="<?php echo $DOB; ?>">

			<label><h4><b>Email: </b></h4></label>
			<input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
			
			<label><h4><b>Username: </b></h4></label>
			<input class="form-control" type="text" name="username" value="<?php echo $username; ?>">

			<label><h4><b>Phone Number: </b></h4></label>
			<input class="form-control" type="text" name="phoneno" value="<?php echo $phoneno; ?>">

			<br>
			<br>
			<div style="padding-left 100px;">
				<button class="savebutton" type="submit" name="savebutton" style="left">Save</button></div>
		</form>
		</div>
	</fieldset>
	
</body>
</html>