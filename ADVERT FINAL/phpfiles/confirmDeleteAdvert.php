<?php include("..\advertQueries.php")?>
<?php
session_start();
$advertID= $_POST['fdelete'] ;
DeleteAdvert($advertID);
header("Location: mainAdvert.php");
exit();
?>