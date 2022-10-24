<!-- 5.1.1 Create notification for upcoming appointment
TESTING
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
TO BE CONFIRMED
- send e-mail to the user registered e-mail 
    use PHPMailer
    use gmail SMTP-->

    <?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

date_default_timezone_set('Asia/Kuching');
$currentTime = date('Y-m-d H:i:s');
$currentTimeLowerLimit = date('Y-m-d H:i:s', strtotime('+25 minutes', strtotime(date('Y-m-d H:i:s'))));
$currentTimeUpperLimit = date('Y-m-d H:i:s', strtotime('+35 minutes', strtotime(date('Y-m-d H:i:s'))));

// set the servername,username and password (PLEASE CHANGE THE VALUE ACCORDINGLY)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CSK";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// search for bookingID with matching date and time from booking table (PLEASE CHANGE TABEL NAME AND COLUMN NAME ACCORDINGLY)
$sql = "SELECT BookingID FROM Bookings WHERE date > '$currentTimeLowerLimit' AND date < '$currentTimeUpperLimit' AND isBooked = '1'";
$result = mysqli_query($conn, $sql);

// if there's bookingID, that means there's an appointment in that slot, so execute the code below
if (mysqli_num_rows($result) > 0) {

    // create notification details
    $subject = "Upcoming Appointment";
    $row = mysqli_fetch_row($result);
    $content = "You have an appointment in 30 minutes with booking ID of " . $row[0] . "." ;

    //search for accountID related to the bookingID
    $sql = "SELECT AccountID FROM BookingDetails WHERE bookingID = '$row[0]'";
    $result = mysqli_query($conn, $sql);

    //check if there are accountID
    if (mysqli_num_rows($result) > 0) {

        //for every  accountID, insert new notification
        while ($row = mysqli_fetch_row($result)) {

            $sql = "INSERT INTO Notifications (accountID, subject, notifDesc, date, isRead) VALUES ('$row[0]', '$subject', '$content', '$currentTime', 'false')";
            if (mysqli_query($conn, $sql) == false) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            $sql = "SELECT email FROM accounts WHERE accountID = '$row[0]'";
            $resultemail = mysqli_query($conn, $sql);

            $row = mysqli_fetch_row($resultemail);

            //maybe put e-mail code here or make a separate php script
            //access email address with $row[0]

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //$mail->Host = 'smtp.gmail.com';                       replace with configuration from e-mail provider
            //$mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            //$mail->Username = 'example@example.com';             replace the admin e-mail
            //$mail->Password = 'passwordpassword';
            //$mail->setFrom('example@example.com', 'Admin');
            $mail->addAddress($row[0]);
            $mail->Subject = $subject;
            $mail->Body    = $content;

            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!'; 
            }
        }
        mysqli_free_result($result);
    }
}

mysqli_close($conn);
?>