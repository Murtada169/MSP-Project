<!-- This PHP script is called from the Advertisement function in Advertisement module
    or the easier way, put the code inside the edit function itself
    that way we can save the trouble of setting up execution of a script from another script

    - get the 'title' and 'advertDesc' (maybe from superglobal [$_POST] ??? from the advertisement control page)
    - set content to 'advertDesc'
    - set subject to 'title'
    - add another details (refer to the other scripts)
    - insert into to database 

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

    // get title and advertDesc and create notification details with them
    $subject = $_POST['title']
    $content = $_POST['advertDesc']

    //populate the notification table (PLEASE CHANGE TABLE NAME AND COLUMN NAME ACCORDINGLY,
    // dateCreated is DATETIME datatype)
    $sql = "INSERT INTO Notifications (AccountID, subject, desc, datetime, isRead) VALUES ('2', '$subject', '$content', '$currentTime', 'false')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
?>