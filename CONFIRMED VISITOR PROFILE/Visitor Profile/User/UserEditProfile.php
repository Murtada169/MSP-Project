<?php
	//session_start();
?>
<!DOCTYPE html>
<html>

<?php include("header.php")?>

<style>
#usereditprofile{
  padding: 300px;
}

#text1{
  font-family: 'Faustina', serif;
  font-weight: bold;
  font-size: 30px;
  text-align: center;
}

.row label{
  color: black;
  font-family: 'Faustina', serif;
  font-weight: bold;
  font-size: 20px;

}

input[type=text], textarea{
  width: 70%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;

}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;

}

input[type=submit] , #button2{
  background-color: #049560;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.savebutton{
  display: flex;
  justify-content: center;

}
/*#button2 a{
  color: white;
  text-decoration: none;
}*/

input[type=submit]:hover , button{
  background-color: #04AA6D;
}

.container {
  border-radius: 5px;
  /* background-color: #f2f2f2; */
  padding: 20px;
  margin-left: 300px;
  margin-right: 80px;
  margin-bottom: 80px;
  /*background-image: url("../../forms_plants.jpg");

  background-repeat: inherit;
  background-size: cover;*/
}

/*#button1,#button2{
  display: inline-block;
  margin: 10px;
}*/

.col-25 {
  float: left;
  width: 25%;
  /*margin-top: 5px;*/
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 35px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

input:read-only {
  background-color: #ccc;
}

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

 .savebutton {
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
.savebutton a{
  text-align: center;
  text-decoration: none;
  color: black;
 
  font-size: 16px;
  margin: 4px 2px;
}
.savebutton:hover {
  background-color: white;
  color: black;
}

</style>

<body>
	<div class="usereditprofile">
	<br><br><br><br><br>
		<h1 id="text1">Edit Profile Information</h1>
	

	<?php

        //include'../../accountsQueries.php';
		include'accountsQueries.php';
        
        //$result = DisplayUserAccountDetails($_POST['editbutton']);
		//$row = mysqli_fetch_assoc($result);

		$result = ViewOwnAccount($_POST['editbutton']);
		while($row = $result->fetch()){
			$accountID = $row['accountID'];

		$accountID=$row['accountID'];
		$fname=$row['fName'];
		$lname=$row['lName'];
        $DOB=$row['DOB'];
        $email=$row['email'];
		$username=$row['username'];
		$password=$row['password'];
		$phoneno=$row['phoneNo'];
		}
		
	?>

	
		<!--<legend><h1 class="form">Personal Details</h1></legend>-->
		<div class="container">
			<form if='form' action="UserEditProfileProcess.php" method="post">


			<input class="form-control" type="hidden" name="accountID"  value="<?php echo $accountID; ?>">

			<div class="row">
				<div class="col-25">
					<label><h4><b>Username: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="username" value="<?php echo $username; ?>" readonly id="read-only">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label><h4><b>First Name: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="fname"  value="<?php echo $fname; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label><h4><b>Last Name: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="lname" value="<?php echo $lname; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label><h4><b>Date of Birth: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="date" name="DOB" value="<?php echo $DOB; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label><h4><b>Email: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label><h4><b>Password: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="password" value="<?php echo $password; ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-25">
					<label><h4><b>Phone Number: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="phoneno" value="<?php echo $phoneno; ?>">
				</div>
			</div>

			<!--<div class="row">-
				<div class="col-25">
					<label><h4><b>Last Visit Date: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="lastVisitDate" value="<?php //echo GetLastVisitDate($accountID); ?>" readonly id="read-only">
				</div>
			</div>-->

			<!--<div class="row">
				<div class="col-25">
					<label><h4><b>Frequency: </b></h4></label>
				</div>
				<div class="col-75">
					<input class="form-control" type="text" name="frequency" value="<?php //echo $; ?>">
				</div>
			</div>-->

			<!--<label><h4><b>Account ID: </b></h4></label>
			<input class="form-control" type="text" name="accountID"  value="<?php //echo $accountID; ?>" readonly>

			<label><h4><b>Username: </b></h4></label>
			<input class="form-control" type="text" name="username" value="<?php //echo $username; ?>" readonly>

			<label><h4><b>First Name: </b></h4></label>
			<input class="form-control" type="text" name="fname"  value="<?php //echo $fname; ?>">

			<label><h4><b>Last Name: </b></h4></label>
			<input class="form-control" type="text" name="lname" value="<?php //echo $lname; ?>">

			<label><h4><b>Date of Birth: </b></h4></label>
			<input class="form-control" type="text" name="DOB" value="<?php //echo $DOB; ?>">

			<label><h4><b>Email: </b></h4></label>
			<input class="form-control" type="text" name="email" value="<?php //echo $email; ?>">

			<label><h4><b>Password: </b></h4></label>
			<input class="form-control" type="text" name="password" value="<?php //echo $password; ?>">

			<label><h4><b>Phone Number: </b></h4></label>
			<input class="form-control" type="text" name="phoneno" value="<?php //echo $phoneno; ?>">

			<label><h4><b>Last Visit Date: </b></h4></label>
			<input class="form-control" type="text" name="lastVisitDate" value="<?php //echo $; ?>">

			<label><h4><b>Frequency: </b></h4></label>
			<input class="form-control" type="text" name="frequency" value="<?php //echo $; ?>">-->
	    
			<br>
			<br>

			<div>
				<button class="savebutton" type="submit" name="savebutton" value="Submit">Save</button>
			</div>

			</form>
			
		</div>
	</div>
	<?php include 'footer.php';?>
</body>
</html>