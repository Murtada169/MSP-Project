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

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all Bookings (returns as $result, needs fetch_assoc to access)
  function ViewBookingsForAdmin(){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings");
    $stmt->execute() or die($GLOBALS['conn']->error);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $GLOBALS['conn'] = null;
    return $stmt;
  }

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
    $stmt = $GLOBALS['conn']->prepare("INSERT into Bookings (date, bookingDesc, isBooked) VALUES (:bookingDate, :bookingDesc, 0)");
    $stmt->bindParam(":bookingDate", $datetime, PDO::PARAM_STR);
    $stmt->bindParam(":bookingDesc", $bookingDesc, PDO::PARAM_STR);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;
  }

  // Takes in bookingID, date, time, description/title as parameters and:
  //  1) UPDATES Bookings tables
  //  2) INSERTS admin confirmation notification to Notifications table
  //  3) INSERTS user Notifications to Notifications table if user had booked it
  function EditBookingFromAdmin($bookingID, $date, $time, $bookingDesc){
    $datetime = $date . " " . $time;
    $stmt = $GLOBALS['conn']->prepare("UPDATE Bookings SET bookingDesc = :bookingDesc, date = :bookingDate WHERE bookingID = :bookingID;
            SET @bDesc = (SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID);
            SET @admin = CONCAT('A booking for ', @bDesc, ' has been updated');
            INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (1, 'Booking updated', @admin, CURRENT_TIMESTAMP, 0)");

    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->bindParam(":bookingDate", $datetime, PDO::PARAM_STR);
    $stmt->bindParam(":bookingDesc", $bookingDesc, PDO::PARAM_STR);

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
        $stmt = $GLOBALS['conn']->prepare("SET @bDesc = (SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID);
                 SET @user = CONCAT('Your booking for ' , @bDesc , ' has been updated by the admin');
                 INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
                  VALUES (:ID, 'Booking updated' ,@user , CURRENT_TIMESTAMP, 0);");
        $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
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
    $stmt = $GLOBALS['conn']->prepare("SET @bDesc = (SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID);
            SET @admin = CONCAT('A booking for ', @bDesc, ' has been deleted');
            INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (1, 'Booking deleted', @admin, CURRENT_TIMESTAMP, 0);");

    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
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
        $stmt = $GLOBALS['conn']->prepare("SET @bDesc = (SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID);
                 SET @user = CONCAT('Your booking for ' , @bDesc , ' has been deleted by the admin');
                 INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
                  VALUES (:ID, 'Booking deleted' ,@user , CURRENT_TIMESTAMP, 0);");
        $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
        $stmt->bindParam(":ID", $id, PDO::PARAM_INT);
        $stmt->execute() or die($GLOBALS['conn']->error);
      }

      $stmt = $GLOBALS['conn']->prepare("DELETE FROM BookingDetails WHERE bookingID = :bookingID");
      $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
      $stmt->execute() or die($GLOBALS['conn']->error);
    }

    $stmt = $GLOBALS['conn']->prepare("DELETE FROM Bookings WHERE bookingID = :bookingID");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);;

    $GLOBALS['conn'] = null;
  }


  // ---------- USER SQL FUNCTIONS ----------

  // Takes in date as a parameter and returns Bookings that are on the selected date and within 2 days from now
  // Returns all Bookings (returns as $result, needs fetch_assoc to access)
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

  //  Takes in bookingID and userID (from session) as paraemters and:
  //  1) INSERTS user confirmation notification to Notifications
  //  2) INSERTS admin confirmation notification to Notifications
  //  3) INSERTS BookingDetails to BookingDetails
  //  4) If 2 people boooked a slot, UPDATE isBooked to 1 in Bookings
  function AddBookingFromUser($bookingID, $userID){
    $stmt = $GLOBALS['conn']->prepare("SET @bDesc = (SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID);
            SET @user = CONCAT('Your booking for ' , @bDesc , ' has been made');
            SET @admin = CONCAT('A booking for ', @bDesc, ' has been made');
            INSERT into BookingDetails VALUES (:bookingID, :userID);
            INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (:userID, 'Booking made', @user, CURRENT_TIMESTAMP, 0);
            INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (1, 'Booking made', @admin, CURRENT_TIMESTAMP, 0);
            SET @isBookedCount = (SELECT COUNT(*) FROM BookingDetails WHERE bookingID = :bookingID);
            UPDATE Bookings SET isBooked = IF(@isBookedCount = 2, 1, 0) WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }

  //  Takes in bookingID and userID (from session) as paraemters and:
  //  1) INSERTS user confirmation notification to Notifications
  //  2) INSERTS admin confirmation notification to Notifications
  //  3) DELETES from BookingDetails table associated with the bookingID
  //  4) If booking slot was full, UPDATE isBooked to 0 in Bookings
  function DeleteBookingFromUser($bookingID, $userID){
    $stmt = $GLOBALS['conn']->prepare("SET @bDesc = (SELECT bookingDesc FROM Bookings WHERE bookingID = :bookingID);
          SET @user = CONCAT('Your booking for ' , @bDesc , ' has been removed');
          SET @username = (SELECT username FROM Accounts WHERE accountID = :userID);
          SET @admin = CONCAT(@username, ' has deleted their booking for ', @bDesc);
          INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
            VALUES (:userID, 'Booking deleted', @user, CURRENT_TIMESTAMP, 0);
          INSERT into Notifications (accountID, subject, notifDesc, date, isRead)
            VALUES (1, 'User deleted booking', @admin, CURRENT_TIMESTAMP, 0);
          SET @isBookedCount = (SELECT COUNT(*) FROM BookingDetails WHERE bookingID = :bookingID);
          UPDATE Bookings SET isBooked = IF(@isBookedCount = 2, 0, 0) WHERE bookingID = :bookingID);");

    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $stmt = $GLOBALS['conn']->prepare("DELETE FROM BookingDetails WHERE bookingID = :bookingID;");
    $stmt->bindParam(":bookingID", $bookingID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);

    $GLOBALS['conn'] = null;
  }

  function ViewMyBookings($accountID){
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Bookings a JOIN BookingDetails b ON b.bookingID = a.bookingID WHERE b.accountID = :accountID AND a.date >= CURRENT_TIMESTAMP;");
    $stmt->bindParam(":accountID", $accountID, PDO::PARAM_INT);
    $stmt->execute() or die($GLOBALS['conn']->error);
    $GLOBALS['conn'] = null;

    return $stmt;
  }
?>
