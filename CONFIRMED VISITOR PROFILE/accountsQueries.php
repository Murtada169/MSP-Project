<?php
  /*// DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $GLOBALS['conn'] = $conn;

  // ---------- GENERAL SQL FUNCTIONS ----------

  // Takes in username and password as parameters (returns true if valid)
  function ValidateLogin($username, $password){
    $sql = "SELECT * FROM accounts WHERE username = '$username' AND password = '$password'";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);

    mysqli_close($GLOBALS['conn']);

    if(mysqli_num_rows($result) == 0){
      return false;
    }else{
      return true;
    }
  }

  // Takes in all parameters from accounts and INSERTS into accounts tables
  function SignUpAddAccount($fname, $lname, $DOB, $email, $username, $password, $phoneno){
    $sql = "INSERT into accounts (fname, lname, DOB, email, username, password, phoneno)
              VALUES ('$fname', '$lname', '$DOB', '$email', '$username', '$password', '$phoneno');";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all accounts (returns as $result, needs fetch_assoc to access)
  function ViewAllAccounts(){
    $sql = "SELECT accountID, fname, lname, DOB, email, username, phoneno FROM accounts";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }

  // Takes in all but password from accounts as parameters and UPDATES into Accounts table
  function EditAccount($accountID, $fname, $lname, $DOB, $email, $username, $phoneno){
    $sql = "UPDATE accounts SET fname='$fname', lname='$lname' , DOB='$DOB', email='$email',
            username='$username', phoneno='$phoneno' WHERE accountID = $accountID;
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES ('$accountID', 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  // Checks to see if username entered is unique for signing up (returns true if its unique)
  function isUsernameUnique($username){
    $sql = "SELECT * FROM accounts WHERE username = '$username'";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);

    $users = mysqli_fetch_all($result);
    mysqli_close($GLOBALS['conn']);

    if(count($users) > 0){
      return false;
    }else{
      return true;
    }
  }

  // ---------- USER SQL FUNCTIONS ----------

  // Takes in account ID and returns the specifed account (returns as $result, needs fetch_assoc to access)
  function ViewOwnAccount($accountID){
    $sql = "SELECT * FROM accounts WHERE accountID = '$accountID'";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
	
    return $result;
  }
  
  function DisplayAccountDetails($accountID){
	$sql = "SELECT accountID, fname, lname, DOB, email, username, phoneno FROM accounts WHERE accountID='$accountID'";
	$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
 
  }
  
  function DisplayUserAccountDetails($accountID){
	$sql = "SELECT accountID, fname, lname, DOB, email, username, password, phoneno FROM accounts WHERE accountID='$accountID'";
	$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
 
  }

  // Takes in all parameters from accounts and UPDATES into Accounts table
  function EditOwnAccount($accountID, $fname, $lname, $DOB, $email, $username, $password, $phoneno){
    $sql = "UPDATE accounts SET fname='$fname', lname='$lname' , DOB='$DOB', email='$email',
            username='$username', password='$password', phoneno='$phoneno' WHERE accountID = $accountID;
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES ('$accountID', 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }
  

// Takes in accountID as a parameter and returns the last visit date
  function GetLastVisitDate($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT MAX(b.date) FROM bookingdetails a JOIN bookings b ON a.bookingID = b.bookingID WHERE a.accountID = :accountID");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
    return $stmt;
  }*/

  
// DO NOT MESS WITH STUFF HERE
// CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";
  $charset = 'utf8mb4';

  try{
    $GLOBALS['conn'] = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // ---------- GENERAL SQL FUNCTIONS ----------

  // Takes in username and password as parameters (returns true if valid)
  function ValidateLogin($username, $password){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Accounts WHERE username = :username AND password = :password");
    $stmt->bindParam(":username", $username, PDO::PARAM_INT);
    $stmt->bindParam(":password", $password, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;

    if(($stmt->rowCount()) == 0){
      while ($row = $stmt->fetch()){
        return $row['role'];
      }
    }
  }

  // Takes in all parameters from Accounts and INSERTS into Accounts tables
  function SignUpAddAccount($fname, $lname, $DOB, $email, $username, $password, $phoneno){
    $stmt = $GLOBALS['conn']->prepare("INSERT into Accounts (fname, lname, DOB, email, username, password, phoneno)
            VALUES (:fname, :lname, :DOB, :email, :username, :password, :phoneno);");
    $stmt->bindParam(":fname", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":lname", $lname, PDO::PARAM_STR);
    $stmt->bindParam(":DOB", $DOB, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt->bindParam(":phoneno", $phoneno, PDO::PARAM_STR);

    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Checks to see if username entered is unique for signing up (returns true if its unique)
  function isUsernameUnique($username){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Accounts WHERE username = :username");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;

    if(($stmt->rowCount()) == 0){
      return true;
    }else{
      return false;
    }
  }

  // Checks to see if email entered is unique for signing up (returns true if its unique)
  function isEmailUnique($email){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Accounts WHERE email = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;

    if(($stmt->rowCount()) == 0){
      return true;
    }else{
      return false;
    }
  }

  // ---------- USER SQL FUNCTIONS ----------

  // Takes in account ID and returns the specifed account (returns as $result, needs fetch_assoc to access)
  function ViewOwnAccount($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Accounts WHERE accountID = :accountID");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt;
  }

  /*function DisplayAccountDetails($accountID){
    $sql = "SELECT accountID, fname, lname, DOB, email, username, phoneno FROM accounts WHERE accountID='$accountID'";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
      mysqli_close($GLOBALS['conn']);
      return $result;
   
    }
    
    function DisplayUserAccountDetails($accountID){
    $sql = "SELECT accountID, fname, lname, DOB, email, username, password, phoneno FROM accounts WHERE accountID='$accountID'";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
      mysqli_close($GLOBALS['conn']);
      return $result;
   
    }*/

  // Takes in all parameters and UPDATES accounts table
  function EditOwnAccount($accountID, $fname, $lname, $DOB, $email, $username, $password, $phoneno){
    $stmt = $GLOBALS['conn']->prepare("UPDATE Accounts SET fname=:fname, lname=:lname , DOB=:DOB, email=:email,
            username=:username, phoneno=:phoneno, password=:password WHERE accountID = :accountID;");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->bindParam(":fname", $fname, PDO::PARAM_STR);
    $stmt->bindParam(":lname", $lname, PDO::PARAM_STR);
    $stmt->bindParam(":DOB", $DOB, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt->bindParam(":phoneno", $phoneno, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (:accountID, 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }

  // Takes in accountID as a parameter and returns the last visit date
  function GetLastVisitDate($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT MAX(b.date) FROM bookingdetails a JOIN bookings b ON a.bookingID = b.bookingID WHERE a.accountID = :accountID");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
    $result = $stmt->fetch();
    return $result[0];
  }

?>
