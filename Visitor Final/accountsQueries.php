<?php
  // DO NOT MESS WITH STUFF HERE
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
  /*1*/
  function ViewAllAccounts(){
    $sql = "SELECT accountID, fname, lname, DOB, email, username, phoneno FROM accounts";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }

  // Takes in all but password from accounts as parameters and UPDATES into Accounts table
  /*2*/
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
  
 /*3*/
 function DisplayAccountDetails($accountID){
	$sql = "SELECT accountID, fname, lname, DOB, email, username, phoneno FROM accounts WHERE accountID='$accountID'";
	$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
 
  }
  /*4*/
  function DisplayUserAccountDetails($accountID){
	$sql = "SELECT accountID, fname, lname, DOB, email, username, password, phoneno FROM accounts WHERE accountID='$accountID'";
	$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
 
  }
  /*5*/
  // Takes in all parameters from accounts and UPDATES into Accounts table
  function EditOwnAccount($accountID, $fname, $lname, $DOB, $email, $username, $password, $phoneno){
    $sql = "UPDATE accounts SET fname='$fname', lname='$lname' , DOB='$DOB', email='$email',
            username='$username', oassword='$password', phoneno='$phoneno' WHERE accountID = $accountID;
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES ('$accountID', 'Account updated', 'Your account details have been updated', CURRENT_TIMESTAMP, 0);";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }
?>
