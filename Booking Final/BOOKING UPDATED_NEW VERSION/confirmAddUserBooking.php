<?php include("..\bookingQueries.php")?>
<?php
session_start();
$bookingID= $_POST['fadd'] ;
$userID = $_POST['userID'];
AddBookingFromUser($bookingID, 2);
header("Location: mainUserBooking.php");
exit();
?>