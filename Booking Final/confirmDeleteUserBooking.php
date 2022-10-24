<?php include("..\bookingQueries.php")?>
<?php
session_start();
$bookingID= $_POST['fdelete'] ;
$userID = $_POST['userID'];
DeleteBookingFromUser($bookingID, $userID);
header("Location: mainUserBooking.php");
exit();
?>