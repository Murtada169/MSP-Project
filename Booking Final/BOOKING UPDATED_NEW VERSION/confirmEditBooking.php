<?php include("..\bookingQueries.php")?>
<?php
session_start();
$bookingID = $_POST['id'] ;
$date = $_POST['fdate'] ;
$time = $_POST['ftime'] ;
$desc = $_POST['fdesc'];
EditBookingFromAdmin($bookingID, $date, $time, $desc);
header("Location: mainbooking.php");
exit();
?>