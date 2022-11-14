<?php 
	//session_start();
 ?>
<!DOCTYPE html>
<html>

<?php include("header.php")?>

<style>
#userviewprofile{
  padding: 150px;
}

#text1{
  font-family: 'Faustina', serif;
  font-weight: bold;
  font-size: 40px;
  text-align: center;
}

#profilePageTable {
margin-left: auto;
margin-right: auto;
font-family: 'Faustina', serif;
/*border-color: #04AA6D;*/
}


#profilePageTable tr, #profilePageTable td{
 padding-right: 50px;
 padding-left: 50px;
 border-style: ridge;
 border-color: #04AA6D;
 /*border: 3px solid;*/
}

#profilePageTable th{
  font-weight: bold;
  font-size: 20px;
  text-align: center;
}

#profilePageTable tr{
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

 .editbutton {
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
.editbutton a{
  text-align: center;
  text-decoration: none;
  color: black;
 
  font-size: 16px;
  margin: 4px 2px;
}
.editbutton:hover {
  background-color: white;
  color: black;
}
</style>
 
 <!--body style="background-color: #daeeca; ">-->
 <body>
 
 		<div class="userviewprofile">
		<h1 id="text1" style="text-align: center;">Profile Page</h1>
		
 			<?php

				include'../../accountsQueries.php';

				$result = ViewOwnAccount(100);

 			?>
 			
			
			<!--<div id="viewProfileDiv">
					<button class='editbutton' name='editbutton' id='editbtn' type='submit'>
						<a href = 'UserEditProfile.php'>	
							<b>Edit Profile</b>
						</a>
					</button>
			</div>-->
		
			<!--<form action='UserEditProfile.php' method='post'>
					<button class='editbutton' name='editbutton' 
					value=$accountID type='submit'><b>Edit Profile</b></button>
			</form>-->

				<table table id='profilePageTable'>
					<?php
						while($row = $result->fetch()){
							$accountID = $row['accountID'];

							
							echo
							"
								<form action='UserEditProfile.php' method='post'>
									<button class='editbutton' style='width: 150px;' 
									name='editbutton' value=$accountID type='submit'>
										<b>Edit Profile</b>
									</button>
								</form>
								
							";

							echo
							"
							

							<tr>
								<td><b>Username</b></td>
								<td>".$row['username']."</td>
							</tr>

							<tr>
								<td><b>First Name</b></td>
								<td>".$row['fName']."</td>
							</tr>

							<tr>
								<td><b>Last Name</b></td>
								<td>".$row['lName']."</td>
							</tr>

							<tr>
								<td><b>Date of Birth</b></td>
								<td>".$row['DOB']."</td>
							</tr>

							<tr>
								<td><b>Email</b></td>
								<td>".$row['email']."</td>
							</tr>

							<tr>
								<td><b>Password</b></td>
								<td>".$row['password']."</td>
							</tr>

							<tr>
								<td><b>Phone Number</b></td>
								<td>".$row['phoneNo']."</td>
							</tr>

							<tr>
								<td><b>Last Visit Date</b></td>
								<td>";
								echo GetLastVisitDate($accountID);
								echo"</td>
							</tr>

							
							";
						}
					?>
				</table>
			
 		</div>
		 <?php include 'footer.php';?>
 </body>
 </html>

<!--<tr>
	<td><b>Account ID</b></td>
	<td>".$row['accountID']."</td>
</tr>	

<tr>
	<td><b>Frequency</b></td>
	<td>TBD</td>
</tr>-->