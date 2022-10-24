<?php
	$server_name = "localhost";
	$user_name = "root";
	$password = "";
	$db_name = "user_test";

	// Create connection 
	$conn = new mysqli($server_name, $user_name, $password, $db_name);
	// check connection 

	if($conn->connect_error){
		die('Connection Fail!'. $connect_error);
	}
?>