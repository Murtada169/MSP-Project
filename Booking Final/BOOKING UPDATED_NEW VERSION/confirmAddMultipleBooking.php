<?php include("..\bookingQueries.php")?>
<?php
session_start();
$date = $_POST['fdate'] ;
$n = $_POST['fnumber'];
//s$time = $_POST['ftime'] ;
$desc = $_POST['fdesc'];
$hrs = $_POST['hour'];
$min = $_POST['mins'];
$time = $hrs.":".$min;
for($i =0; $i<$n ; $i++){
    AddBookingsFromAdmin($date, $time, $desc);
    $date = date('Y-m-d' ,strtotime($date. ' + 1 days'));
}
header("Location: mainbooking.php");
exit();
?>
