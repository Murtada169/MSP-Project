<?php include("..\bookingQueries.php")?>
<?php
session_start();
$bookingID= $_POST['fdelete'] ;
DeleteBookingFromAdmin($bookingID);
header("Location: mainbooking.php");
exit();
?>