<!-- 
    This PHP script is called from the cancellation function in booking module
    or the easier way, put the code inside the cancelation function itself
    that way we can save the trouble of setting up execution of a script from another script

    - get the boookingID (maybe from superglobal [$_POST] ??? from the booking page)
    - find the user with related bookingID
    - set content to 'Your appointment with booking ID bookingID has been cancelled by username'
    - add another details (refer to the other script)
    - insert into to database

TODO
- send e-mail to the user registered e-mail 
    use PHPMailer
    gmail SMTP no longer available, use zoho or mailjet
 -->

<?php
    date_default_timezone_set('Asia/Kuching');
    $currentTime = date('Y-m-d H:i:s');

    // set the servername,username and password (PLEASE CHANGE THE VALUE ACCORDINGLY)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Testdb";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // get the bookingID from another page/script
    $BookingID = $_POST['BookingID']

    //find the related AccountID from BookingDetails
    $sql = "SELECT AccountID FROM BookingDetails WHERE BookingID = $BookingID";
    $AccountID = mysqli_query($conn, $sql);

    // create notification details
    $subject = 'Canncelation of Appointment'
    $content = 'You have an appointment has been cancelled'

    //populate the notification table (PLEASE CHANGE TABLE NAME AND COLUMN NAME ACCORDINGLY,
    // dateCreated is DATETIME datatype)
    $sql = "INSERT INTO Notifications (AccountID, subject, desc, datetime, isRead) VALUES ('$AccountID', '$subject', '$content', '$currentTime', 'false')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
?>