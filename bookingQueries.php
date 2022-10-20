<?php
  // DO NOT MESS WITH STUFF HERE
  // CHANGE WHEN MIGRATING TO SERVER
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CSK";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $GLOBALS['conn'] = $conn;

  // ---------- ADMIN SQL FUNCTIONS ----------

  // Returns all bookings (returns as $result, needs fetch_assoc to access)
  function ViewBookingsForAdmin(){
    $sql = "SELECT * FROM bookings";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }

  // Takes in date, time and description/title as parameters and INSERTS into Bookings table
  function AddBookingsFromAdmin($date, $time, $bookingDesc){
    $datetime = $date . " " . $time;
    $sql = "INSERT into bookings (date, bookingDesc, isBooked) VALUES ('$datetime', '$bookingDesc', 0)";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  // Takes in bookingID, date, time, description/title as parameters and:
  //  1) UPDATES Bookings tables
  //  2) INSERTS admin confirmation notification to Notifications table
  //  3) INSERTS user notifications to Notifications table if user had booked it
  function EditBookingFromAdmin($bookingID, $date, $time, $bookingDesc){
    $datetime = $date . " " . $time;
    $sql = "UPDATE bookings SET bookingDesc = '$bookingDesc', date = '$datetime' WHERE bookingID = '$bookingID';
            SET @bDesc = (SELECT bookingDesc FROM bookings WHERE bookingID = '$bookingID');
            SET @admin = CONCAT('A booking for ', @bDesc, ' has been updated');
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (1, 'Booking updated', @admin, CURRENT_TIMESTAMP, 0)";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);

    $sql2 = "SELECT * from bookingdetails WHERE bookingID = '$bookingID'";
    mysqli_close($GLOBALS['conn']);

    $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    $result = $conn->query($sql2) or die($conn->error);

    $resultArray= array();

    while ($row = $result->fetch_assoc()){
      array_push($resultArray, $row["accountID"]);
    }

    if(count($resultArray) > 0){
      foreach($resultArray as $id){
        $sql3 = "SET @bDesc = (SELECT bookingDesc FROM bookings WHERE bookingID = '$bookingID');
                 SET @user = CONCAT('Your booking for ' , @bDesc , ' has been updated by the admin');
                 INSERT into notifications (accountID, subject, notifDesc, date, isRead)
                  VALUES ('$id', 'Booking updated' ,@user , CURRENT_TIMESTAMP, 0);";
        mysqli_close($conn);
        $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        mysqli_multi_query($conn,$sql3);
      }
    }

    mysqli_close($conn);
  }

  // Takes in bookingID as a parameter and:
  //  1) INSERTS admin confirmation notifications to Notifications table
  //  2) INSERTS user notifications to Notifications table if user had booked it
  //  3) DELETES from BookingDetails table associated with the bookingID
  //  4) DELETES from Bookings table associated with the bookingID
  function DeleteBookingFromAdmin($bookingID){
    $sql = "SET @bDesc = (SELECT bookingDesc FROM bookings WHERE bookingID = '$bookingID');
            SET @admin = CONCAT('A booking for ', @bDesc, ' has been deleted');
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (1, 'Booking deleted', @admin, CURRENT_TIMESTAMP, 0)";
    $result = $conn->multi_query($sql) or die($conn->error);

    $sql2 = "SELECT * from bookingdetails WHERE bookingID = '$bookingID'";
    mysqli_close($GLOBALS['conn']);

    $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    $result = $conn->query($sql2) or die($conn->error);

    $resultArray= array();

    while ($row = $result->fetch_assoc()){
      array_push($resultArray, $row["accountID"]);
    }

    if(count($resultArray) > 0){

      foreach($resultArray as $id){
        $sql3 = "SET @bDesc = (SELECT bookingDesc FROM bookings WHERE bookingID = '$bookingID');
                 SET @user = CONCAT('Your booking for ' , @bDesc , ' has been deleted by the admin');
                 INSERT into notifications (accountID, subject, notifDesc, date, isRead)
                  VALUES ('$id', 'Booking deleted' ,@user , CURRENT_TIMESTAMP, 0);";
        mysqli_close($conn);
        $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        mysqli_multi_query($conn,$sql3);
      }

      $sql4 = "DELETE FROM bookingdetails WHERE bookingID = '$bookingID'";
      mysqli_close($conn);
      $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
      $result = $conn->query($sql4) or die($conn->error);
    }

    $sql5 = "DELETE FROM bookings WHERE bookingID = '$bookingID'";
    mysqli_close($conn);
    $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    $result = $conn->query($sql5) or die($conn->error);

    mysqli_close($conn);
  }


  // ---------- USER SQL FUNCTIONS ----------

  // Takes in date as a parameter and returns bookings that are on the selected date and within 2 days from now
  // Returns all bookings (returns as $result, needs fetch_assoc to access)
  function ViewBookingsFromUser($date){
    $datetime = new DateTime($date);
    $datetime = $datetime->format('Y-m-d');
    $newdatetime = new DateTime(" + 2 days $date");
    $newdatetime = $newdatetime->format('Y-m-d');

    $sql = "SELECT bookingID, date, bookingDesc, isBooked FROM bookings WHERE date >= \"$datetime\" AND date < \"$newdatetime\"";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
    return $result;
  }

  //  Takes in bookingID and userID (from session) as paraemters and:
  //  1) INSERTS user confirmation notification to Notifications
  //  2) INSERTS admin confirmation notification to Notifications
  //  3) INSERTS bookingdetails to BookingDetails
  //  4) If 2 people boooked a slot, UPDATE isBooked to 1 in Bookings
  function AddBookingFromUser($bookingID, $userID){
    $sql = "SET @bDesc = (SELECT bookingDesc FROM bookings WHERE bookingID = '$bookingID');
            SET @user = CONCAT('Your booking for ' , @bDesc , ' has been made');
            SET @admin = CONCAT('A booking for ', @bDesc, ' has been made');
            INSERT into bookingdetails VALUES ('$bookingID', '$userID');
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES ('$userID', 'Booking made', @user, CURRENT_TIMESTAMP, 0);
            INSERT into notifications (accountID, subject, notifDesc, date, isRead)
              VALUES (1, 'Booking made', @admin, CURRENT_TIMESTAMP, 0);
            SET @isBookedCount = (SELECT COUNT(*) FROM bookingdetails WHERE bookingID = '$bookingID');
            UPDATE bookings SET isBooked = IF(@isBookedCount = 2, 1, 0) WHERE bookingID = '$bookingID';";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);
  }

  //  Takes in bookingID and userID (from session) as paraemters and:
  //  1) INSERTS user confirmation notification to Notifications
  //  2) INSERTS admin confirmation notification to Notifications
  //  3) DELETES from BookingDetails table associated with the bookingID
  //  4) If booking slot was full, UPDATE isBooked to 0 in Bookings
  function DeleteBookingFromUser($bookingID, $userID){
    $sql="SET @bDesc = (SELECT bookingDesc FROM bookings WHERE bookingID = '$bookingID');
          SET @user = CONCAT('Your booking for ' , @bDesc , ' has been removed');
          SET @username = (SELECT username FROM accounts WHERE accountID = '$userID');
          SET @admin = CONCAT(@username, ' has deleted their booking for ', @bDesc);
          INSERT into notifications (accountID, subject, notifDesc, date, isRead)
            VALUES ('$userID', 'Booking deleted', @user, CURRENT_TIMESTAMP, 0);
          INSERT into notifications (accountID, subject, notifDesc, date, isRead)
            VALUES (1, 'User deleted booking', @admin, CURRENT_TIMESTAMP, 0);
          SET @isBookedCount = (SELECT COUNT(*) FROM bookingdetails WHERE bookingID = '$bookingID');
          UPDATE bookings SET isBooked = IF(@isBookedCount = 2, 0, 0) WHERE bookingID = '$bookingID';";
    $result = $GLOBALS['conn']->multi_query($sql) or die($GLOBALS['conn']->error);
    mysqli_close($GLOBALS['conn']);

    $sql2 = "DELETE FROM bookingdetails WHERE bookingID = '$bookingID';";
    $conn = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    $result = $conn->query($sql2) or die($conn->error);

    mysqli_close($conn);
  }
?>
