<?php include("..\bookingQueries.php")?>
<?php
session_start();
$date = $_POST['fdate'] ;
//s$time = $_POST['ftime'] ;
$desc = $_POST['fdesc'];
$hrs = $_POST['hour'];
$min = $_POST['mins'];
$time = $hrs.":".$min;
// CHECK IF THERE IS ANY BOOKINGS DONE ON THE SAME TIME AND DATE 

if(AddBookingsFromAdmin($date, $time, $desc)){
    header("Location: mainbooking.php");
    exit();
}else{
?>
<script>
        window.location.replace("addbooking.php");
        alert("Booking has been made for this slot, Please choose another slot\n Date: "+$date" Time: "+$time);
</script>
<?php
}
?>