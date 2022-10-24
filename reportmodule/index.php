<?php
    $conn = mysqli_connect("localhost","root","","charts");
    $GLOBALS['conn'] = $conn;
  // if($con){
  //   echo "connected";
  // }

  function NumberOfVisitorsPerDay(){
    $sql = "SELECT COUNT(b.accountID) AS Visitors, CAST(a.date as DATE) AS Date FROM bookings as a JOIN bookingdetails as b ON a.bookingID = b.bookingID GROUP BY CAST(a.date as DATE)";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    $data = [];
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    } 
    return $data;
  }

  // Which time is most preferred
  function TimeMostPreferred(){
    $sql = "SELECT COUNT(b.accountID) AS Visitors, CAST(a.date as TIME) AS TIME FROM bookings as a JOIN bookingdetails as b ON a.bookingID = b.bookingID GROUP BY CAST(a.date as TIME)";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    $data = [];
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    } 
    return $data;
  }

  // Bookings per visitor
  function BookingsPerVisitor(){
    $sql = "SELECT COUNT(b.accountID) AS Visitors, a.username FROM accounts as a JOIN bookingdetails as b ON a.accountID = b.accountID GROUP BY b.accountID";
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    $data = [];
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    } 
    return $data;
  }
  $chart_data = NumberOfVisitorsPerDay();
  $chart_data2 = TimeMostPreferred();
  $chart_data3 = BookingsPerVisitor();
  mysqli_close($GLOBALS['conn']);
  
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="description" content="sign up " />
	<meta name="keywords" content=", sign up" />
	<meta name="author" content="Munaamullah Khan" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Visitor Activities</title>

	<link rel="stylesheet" href="Munaamstyle.css" />
	<script src="script.js"></script>
</head>

<body>
	<header>
		<a href="TBD">
			<h1 class="Logo"> Cacti-Succulent </h1>
		</a>
		<nav>
			<div class="dropdown-content">
				<ul class="link" id="mainUl">



					<li><a href="signup.html">Sign up</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
				</ul>
			</div>
		</nav>
		<a class="about" href="TBD">TBD</a>
	</header>
	<div class="prime">
		<section class="charts">


			<div id="barchart" style="width: 400px; height: 300px; margin-top:10px;"></div>
			<br>
			<br>
			<div id="barchart2" style="width: 400px; height: 300px;"></div>
			<br>
			<br>
			<div id="barchart3" style="width: 400px; height: 300px;"></div>
		
			</section>
	</div>
	<!--footer-->
	<footer>
		<div class="foot-content">

			<div class="navbox">
				<h2> Navigator</h2>
				<ul>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD">TBD</a></li>
					<li><a href="TBD"> Home</a></li>
				</ul>
			</div>
			<div class="leftside">
				<h2>About Us</h2>
				<p>Cacti-Succulent Kuching is a local homegrown business specialized in selling various
					type and size of succulent plants. Apart from selling succulent plants, they also sell different
					type
					of gardening tools, soils and fertilizers at an affordable cost. Cacti-Succulent Kuching is setup in
					2020 in which business is running both at home as well as weekend market.</p>
				<h3>"We Bring Good Things to Life"</h3>
				<h3>Provide the Best Experience within a Single Touch.</h3>
			</div>
			<div class="rightside">
				<h2>Visit Us</h2>
				<h3>Social Media</h3>
				<ol>
					<li><a href="https://youtube.com" class="button" target="_blank">Youtube</a></li>
					<li><a href="https://facebook.com" class="button" target="_blank">Facebook</a></li>
					<li><a href="https://instagram.com" class="button" target="_blank">Instagram</a></li>
					<li><a href="https://whatsapp.com" class="button" target="_blank">Whatsapp</a></li>
				</ol>
			</div>
		</div>

	</footer>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);
      google.charts.setOnLoadCallback(drawChart3);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([['Visitors','Date'], 
        <?php
          foreach($chart_data as $key => $value) {
            echo"['".$value['Date']."',".$value['Visitors']."],";
          }
        ?>
      ]);
        var options = {
          title: 'NumberOfVisitorsPerDay'
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));
        chart.draw(data, options);
      }
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([['TIME', 'Visitors'], 
          <?php
            foreach ($chart_data2 as $key => $value) {
              echo"['".$value['TIME']."',".$value['Visitors']."],";
            }
          ?>
        ]);
        var options = {
          title: 'TimeMostPreferred'
        };
        var chart2 = new google.visualization.ColumnChart(document.getElementById('barchart2'));
        chart2.draw(data, options);
      }
      function drawChart3() {
        var data = google.visualization.arrayToDataTable([['username', 'Visitors'], 
        <?php
          foreach ($chart_data3 as $key => $value) {
            echo"['".$value['username']."',".$value['Visitors']."],";
          }
        ?>]);
        var options = {
          title: 'BookingsPerVisitor'
        };
        var chart3 = new google.visualization.ColumnChart(document.getElementById('barchart3'));
        chart3.draw(data, options);
      }
    </script>



</body>

</html>