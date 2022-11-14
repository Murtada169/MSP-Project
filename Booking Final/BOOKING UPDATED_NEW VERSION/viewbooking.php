<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Booking</title>
  <?php include("..\bookingQueries.php") ?>
</head>
<?php include 'Header.php';?>
<body> 
	<?php include 'navigation.php';?>
	<div class="main">
		<h1  id = "text1" class="fill">View Booking Manager </h1>
        <div id="enquirytable">
        <table class="view_enquiry">
    <tr >
          <th>Date</th>
          <th>Time</th>
          <th>Description</th>
          <th>Appointee 1 </th>
          <th>Appointee 2 </th>
    </tr>
        <?php
        $id= $_POST['fview'] ;
        $result = GetOneBooking($id);
	      while($row = $result->fetch()){
        $datetime = $row["date"];
        $bookingID = $row["bookingID"];
        $date_arr= explode(" ", $datetime);
        $date= $date_arr[0];
        $time= $date_arr[1];
        $desc = $row["bookingDesc"];
        // add the appointees 
?>
    <tr>
      <td><?php echo $date; ?></td>
      <td><?php echo $time; ?></td>
      <td><?php echo $desc; ?></td>
      <td><?php echo "aa";//echo $row["Appointee 1 "]; ?></td>
      <td><?php echo "aa";//echo $row["Appointee 2 "]; ?></td>
      <?php
        }
      ?>
    </tr>
    </table>
    </div>
    <?php //include 'footer.php';?>
</body>
</html>
