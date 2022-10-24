<?php include("..\bookingQueries.php")?>
<?php
session_start();
$date = $_POST['fdate'] ;
$time = $_POST['ftime'] ;
$desc = $_POST['fdesc'];
AddBookingsFromAdmin($date, $time, $desc);
header("Location: mainbooking.php");
exit();
?>