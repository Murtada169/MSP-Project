<?php
 	class Model
 	{
 		private $conn;
 		function __construct($conn = null)
 		{
 			$this->conn = $conn;
 		}
		public function insertData($data){
			if(!empty($_POST)){
				$fname = $_POST['fname']; 
				$flname = $_POST['flname']; 
				$fdob = $_POST['fdob']; 
				$funame = $_POST['funame']; 
				$femail = $_POST['femail']; 
				$fphone = $_POST['fphone'];
				$pass = md5($_POST['pass']);

				$sql = "SELECT id FROM users WHERE funame='$funame'";
				$result = $this->conn->query($sql);
				if ($result->num_rows > 0) {
				  while($row = $result->fetch_assoc()) {
				  	if($row['funame'] == 1){
						$_SESSION['success'] = "Email Already Exits";
						return true;
				  	}
				  }
				}

				$sql = "INSERT INTO users (fname, flname, fdob, funame, femail, pass, fphone)
				VALUES ('$fname', '$flname', '$fdob', '$funame', '$femail', '$pass', '$fphone')";

				if ($this->conn->query($sql) === TRUE) {
					$_SESSION['success'] = "New record created successfully";
					return true;
				} else {
				  	$_SESSION['error'] = "something went wrong!";
					return false;
				}

			}
			return true;
		}
		public function getData($data){
			$funame = $_POST['funame'];
			
			$pass = md5($_POST['pass']);
			$sql = "SELECT * FROM users WHERE funame='$funame' AND pass='$pass'";
			$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			  // output data of each row
			  while($row = $result->fetch_assoc()) {
			  	if($row['role'] == 1){
					$_SESSION['success'] = "Admin logged in Successfully";
			  	}else{
					$_SESSION['success'] = $row['fname']." logged in Successfully";
			  	}
			  }
			  return true;
			} else {
				$_SESSION['error'] = "User doesn't exists!";
				return false;
			}
			
		}
 	}
?>