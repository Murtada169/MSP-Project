<?php
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

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all Bookings (returns as $result, needs fetch to access)
  function ViewAllBookings(){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings");
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // Takes in bookingID as a parameter and returns the booking (returns as $result, needs fetch to access)
  function GetOneBooking($bookingID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE bookingID = :bookingID");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

  // Takes in date, time and description/title as parameters and INSERTS into Bookings table
  function AddBookingsFromAdmin($date, $time, $bookingDesc){
    $datetime = $date . " " . $time;
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE date = :datetime");
    $stmt->bindParam(":datetime", $datetime, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->fetch() == 0){
      $stmt = $GLOBALS['conn']->prepare("INSERT into Bookings (date, bookingDesc, isBooked) VALUES (:bookingDate, :bookingDesc, 0)");
      $stmt->bindParam(":bookingDate", $datetime, PDO::PARAM_STR);
      $stmt->bindParam(":bookingDesc", $bookingDesc, PDO::PARAM_STR);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $GLOBALS['conn'] = null;
      return true;
    }
    else{
      return false;
    }
  }

  // Takes in bookingID, date, time, description/title as parameters and:
  //  1) UPDATES Bookings tables
  //  2) INSERTS admin confirmation notification to Notifications table
  //  3) INSERTS user Notifications to Notifications table if user had booked it
  function EditBookingFromAdmin($bookingID, $date, $time, $bookingDesc){
    $datetime = $date . " " . $time;
    $stmt = $GLOBALS['conn']->prepare("UPDATE Bookings SET bookingDesc = :bookingDesc, date = :bookingDate WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->bindParam(":bookingDate", $datetime, PDO::PARAM_STR);
    $stmt->bindParam(":bookingDesc", $bookingDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $notifDesc = "A booking for ".$bookingDesc." has been updated";
    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
            VALUES (1, 'Booking updated', :notifDesc, CURRENT_TIMESTAMP)");
    $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("SELECT * from BookingDetails WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $resultArray= array();

    while ($row = $stmt->fetch()){
      array_push($resultArray, $row["accountID"]);
    }

    if(count($resultArray) > 0){
      foreach($resultArray as $id){
        $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
                  VALUES (:ID, 'Booking updated' , :notifDesc , CURRENT_TIMESTAMP);");
        $notifDesc = "Your booking for ".$bookingDesc." has been updated";
        $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
        $stmt->bindParam(":ID", $id, PDO::PARAM_INT);
        $stmt->execute() or die($GLOBALS['conn']->error);
      }
    }

    $GLOBALS['conn'] = null;
  }

  // Takes in bookingID as a parameter and:
  //  1) INSERTS admin confirmation Notifications to Notifications table
  //  2) INSERTS user Notifications to Notifications table if user had booked it
  //  3) DELETES from BookingDetails table associated with the bookingID
  //  4) DELETES from Bookings table associated with the bookingID
  function DeleteBookingFromAdmin($bookingID){
    $stmt = $GLOBALS['conn']->prepare("SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $desc = $stmt->fetch()[0];

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
             VALUES (1, 'Booking deleted', :notifDesc, CURRENT_TIMESTAMP);");
    $notifDesc = "A booking for ".$desc." has been deleted";
    $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("SELECT * from BookingDetails WHERE bookingID = :bookingID");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $resultArray= array();

    while ($row = $stmt->fetch()){
      array_push($resultArray, $row["accountID"]);
    }

    if(count($resultArray) > 0){

      foreach($resultArray as $id){
        $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
                  VALUES (:ID, 'Booking deleted' , :notifDesc , CURRENT_TIMESTAMP);");
        $notifDesc = "Your booking for ".$desc." has been deleted";
        $stmt->bindParam(":ID", $id, PDO::PARAM_INT);
        $stmt->bindParam(":notifDesc", $notifDesc, PDO::PARAM_STR);
        $stmt->execute() or die($GLOBALS['conn']->error);
      }

      $stmt = $GLOBALS['conn']->prepare("DELETE FROM BookingDetails WHERE bookingID = :bookingID");
      $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }

    $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE bookingID = :bookingID");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }


  // ---------- USER SQL FUNCTIONS ----------

  // Takes in date as a parameter and returns Bookings that are on the selected date and within 2 days from now
  // Returns all Bookings (returns as $result, needs fetch to access)
  function ViewBookingsFromUser($date){
    $datetime = new DateTime($date);
    $datetime = $datetime->format('Y-m-d');
    $newdatetime = new DateTime(" + 2 days $date");
    $newdatetime = $newdatetime->format('Y-m-d');

    $stmt = $GLOBALS['conn']->prepare("SELECT bookingID, date, bookingDesc, isBooked FROM Bookings WHERE date >= :bookingDate AND date < :newDate;");
    $stmt->bindParam(":bookingDate", $datetime, PDO::PARAM_STR);
    $stmt->bindParam(":newDate", $newdatetime, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;

    return $stmt;
  }

  //  Takes in bookingID and accountID (from session) as paraemters and:
  //  1) INSERTS user confirmation notification to Notifications
  //  2) INSERTS admin confirmation notification to Notifications
  //  3) INSERTS BookingDetails to BookingDetails
  //  4) If 2 people boooked a slot, UPDATE isBooked to 1 in Bookings
  function AddBookingFromUser($bookingID, $accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();

    $notifUser = "Your booking for ".$result[2]." has been made";
    $notifAdmin = "A booking for ".$result[2]." has been made";

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
               VALUES (:accountID, 'Booking made', :notifUser, CURRENT_TIMESTAMP)");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->bindParam(":notifUser", $notifUser, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
               VALUES (1, 'Booking made', :notifAdmin, CURRENT_TIMESTAMP)");
    $stmt->bindParam(":notifAdmin", $notifAdmin, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("INSERT into BookingDetails VALUES (:bookingID, :accountID);");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) FROM BookingDetails WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();

    if(($result[0]) == 2){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Bookings SET isBooked = 1 WHERE bookingID = :bookingID;");
      $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $result = $stmt->fetch();
    }

    $GLOBALS['conn'] = null;
  }

  //  Takes in bookingID and accountID (from session) as paraemters and:
  //  1) INSERTS user confirmation notification to Notifications
  //  2) INSERTS admin confirmation notification to Notifications
  //  3) DELETES from BookingDetails table associated with the bookingID
  //  4) If booking slot was full, UPDATE isBooked to 0 in Bookings
  function DeleteBookingFromUser($bookingID, $accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result1 = $stmt->fetch();

    $notifUser = "Your booking for ".$result1[2]." has been removed";

    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Accounts WHERE accountID = :accountID;");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result2 = $stmt->fetch();

    $notifAdmin = $result2[5]." has removed their booking for ".$result1[2];

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
               VALUES (:accountID, 'Booking removed', :notifUser, CURRENT_TIMESTAMP)");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->bindParam(":notifUser", $notifUser, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("INSERT into Notifications (accountID, subject, notifDesc, date)
               VALUES (1, 'Booking removed', :notifAdmin, CURRENT_TIMESTAMP)");
    $stmt->bindParam(":notifAdmin", $notifAdmin, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) FROM BookingDetails WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $result = $stmt->fetch();

    if(($result[0]) == 2){
      $stmt = $GLOBALS['conn']->prepare("UPDATE Bookings SET isBooked = 0 WHERE bookingID = :bookingID;");
      $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
      $result = $stmt->fetch();
    }

    $stmt = $GLOBALS['conn']->prepare("DELETE FROM BookingDetails WHERE bookingID = :bookingID AND accountID = :accountID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }

  // Takes in the accountID and returns all the Bookings (returns as $result, needs fetch to access)
  function ViewMyBookings($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings a JOIN BookingDetails b ON b.bookingID = a.bookingID WHERE b.accountID = :accountID AND a.date >= CURRENT_TIMESTAMP;");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;

    return $stmt;
  }
?>
