<?php
  // DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "id19606244_cskadmin";
  $password = "iY5pW(%cpS!]VXy/";
  $dbname = "id19606244_csk";
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

  // Takes in all parameters and UPDATES accounts table
  function EditOwnAccount($accountID, $fname, $lname, $DOB, $email, $username, $password, $phoneno){
    $stmt = $GLOBALS['conn']->prepare("UPDATE Accounts SET fname=:fname, lname=:lname , DOB=:DOB, email=:email,
            username=:username, phoneno=:phoneno WHERE accountID = :accountID;");
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
    return $stmt;
  }
?>
