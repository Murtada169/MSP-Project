<?php 
    include'../../accountsQueries.php';

	//	if(isset($_POST['submit']))
	
			
            
            $accountID=$_POST['accountID'];
            $fName=$_POST['fname'];
			$lName=$_POST['lname'];
            $DOB=$_POST['DOB'];
            $email=$_POST['email'];
			$username=$_POST['username'];
			$phoneNo=$_POST['phoneno'];

            echo $accountID;
            echo $fName;
            echo $lName;
            echo $DOB;
            echo $email;
            echo $username;
            echo $phoneNo;
			//$sql1= "UPDATE admin SET pic='$pic', first='$first', last='$last', username='$username', password='$password', email='$email', contact='$contact' WHERE username='".$_SESSION['login_user']."';";

            EditAccount($accountID, $fName, $lName, $DOB, $email, $username, $phoneNo);
            //EditOwnAccount($accountID, $fname, $lname, $DOB, $email, $username, $password, $phoneno)

           /*$sql = "UPDATE accounts SET fname='$fname', lname='$lname' , DOB='$DOB', email='$email',
            username='$username', oassword='$password', phoneno='$phoneno' WHERE accountID = $accountID;
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES ('$accountID', 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);";*/

			/*if(mysqli_query($conn,$sql))
			{
				?>
					<script type="text/javascript">
						alert("Saved.");
						window.location="AdminViewProfile.php";
					</script>
				<?php
			}*/
		
 	?>