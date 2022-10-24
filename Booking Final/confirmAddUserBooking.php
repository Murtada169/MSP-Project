<?php include("..\bookingQueries.php")?>
<?php
session_start();
$bookingID= $_POST['fadd'] ;
$userID = $_POST['userID'];
AddBookingFromUser($bookingID, $userID);
header("Location: mainUserBooking.php");
exit();
?>