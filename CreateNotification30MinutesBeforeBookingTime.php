<!-- 5.1.1 Create notification for upcoming appointment
TODO
- github action or cron-job.org execute the PHP script (a url containing the PHP script in our website???)
	 at XX:30 (every 30th minute of the hour) or another time interval
	 or check if the webhosting has a scheduler (cronjobs)
TO BE CONFIRMED
- When executed this PHP script checks for any upcoming booking in 30 minutes
    adjust the timezone
	get the current hour using date()
		SELECT any booking time within XX:10 and XX:50,
	 which is the actual booking time and the upper and lower range,
	 e.g. SELECT * FROM booking_table WHERE bookingtime <= XX:50 AND bookingtime >= XX:10
	 the purpose of the range is that the scheduler might run late
TO BE CONFIRMED
- if there's any, create the notification details
	-notifID (timecreated?/basic increment?)
	-subject ('Upcoming Appoinment')
	-content (the content is e.g. 'Upcoming appointment at ' + booking_time + booking_date from the booking_table in the database)
	-recipient (get this from the booking_table)
TO BE CONFIRMED
- PHP script populate the table with the above notification details 
TODO
- send e-mail to the user registered e-mail HOW THE FUCK CAN I SET THIS UP-->

<?php
    date_default_timezone_set('Asia/Kuching');
    $currentTime = date('Y-m-d H:i:s');
    $currentTimeLowerLimit = date('Y-m-d H:i:s', strtotime('+25 minutes', strtotime(date('Y-m-d H:i:s'))));
    $currentTimeUpperLimit = date('Y-m-d H:i:s', strtotime('+40 minutes', strtotime(date('Y-m-d H:i:s'))));

    // set the servername,username and password (PLEASE CHANGE THE VALUE ACCORDINGLY)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Testdb";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // search for userID with matching date and time from booking table (PLEASE CHANGE TABEL NAME AND COLUMN NAME ACCORDINGLY)
    $sql = "SELECT userID FROM BookingList WHERE bookingtime > $currentTimeLowerLimit AND bookingtime < $currentTimeUpperLimit";
    $resultUserID = mysqli_query($conn, $sql);

    // if there's userID, that means there's an appointment in that slot, so execute the code below
    if (mysqli_num_rows($result) > 0) {
        // create notification details
        $subject = 'Upcoming Appointment'
        $content = 'You have an appointment in 30 minutes'

        //populate the notification table (PLEASE CHANGE TABLE NAME AND COLUMN NAME ACCORDINGLY,
        // dateCreated is DATETIME datatype, recipiet)
        $sql = "INSERT INTO NotificationTable (recipientID, subject, content, dateCreated) VALUES ('$resultUserID', '$subject', '$content', $currentTime)";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    } else {
        echo "0 results";
    }
?>