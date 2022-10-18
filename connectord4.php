<?php

  // DO NOT MESS WITH STUFF HERE
  // FOR ACTUAL SERVER USE
  $servername = "localhost";
	$username = "id19606244_cskadmin";
	$password = "iY5pW(%cpS!]VXy/";
	$dbname = "id19606244_csk";

  // FOR LOCAL SERVER USE
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";

	$conn = mysqli_connect($servername, $username, $password, $dbname); // DO NOT CHANGE, establish connection

  // DO NOT CHANGE, error validation for connection
	if (!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}
	else{
		echo "";
	}

  // IMPORTANT: FOR SOME FUCKING REASON SERVER DATA TABLE NAMES ARE CASE SENSITIVE (e.g, localhost: accounts/Accounts, server: Accounts)
  // KEEP IN MIND CAPITAILISATION (refer to phpmyadmin for actual name)
  $sql = "SELECT fName, lName, username FROM Accounts WHERE accountID = 1"; // insert query here
  $result = $conn->query($sql) or die($conn->error); // DO NOT CHANGE, relays query to database

  $row = $result->fetch_assoc(); // DO NOT CHANGE, fetches results
  echo $row["fName"]; // display result(s)

  //while($row = $result->fetch_assoc()){ // DO NOT CHANGE, for fetching multiple data/columns/both
  //  echo ...;
  //}

 mysqli_close($conn); // DO NOT CHANGE, closes connection
?>
