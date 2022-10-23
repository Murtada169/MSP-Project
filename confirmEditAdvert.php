<?php include("..\advertQueries.php")?>
<?php
session_start();
$advertID = $_POST['id'] ;
$advertDesc = $_POST['fdesc'];
$title = $_POST['ftitle'];
$imgName = $_POST['fimage'];

EditAdverts($advertID, $imgName, $title, $advertDesc);

header("Location: mainAdvert.php");
exit();
?>