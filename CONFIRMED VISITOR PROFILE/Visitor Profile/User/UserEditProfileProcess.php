<!doctype html>
<html>
<?php include("header.php")?>


<style>
    #userviewprofile{
    padding: 200px;
    }
    .text1{
    font-family: 'Faustina', serif;
    font-weight: bold;
    font-size: 50px;
    text-align: center;
    }

    button{
    border: none;
    background-color: none;
    z-index: 1;
    }
    .viewProfilebutton {
    margin-bottom: 20px;
    display: block;
    margin-left: auto;
    margin-right: auto;

    background-color: #04AA6D; /* Green */
    border: 2px solid #04AA6D;
    color: white;
    /*padding: 15px 32px;*/
    padding-top: 8px;
    padding-right: 8px;
    padding-bottom: 8px;
    padding-left: 8px;
        
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .viewProfilebutton a{
    text-align: center;
    text-decoration: none;
    color: black;
    
    font-size: 16px;
    margin: 5px 5px;
    }
    .viewProfilebutton:hover {
    background-color: white;
    color: black;
    }    
</style>

<body> 
    <div class=usereditprofileprocess> 
    <br><br><br><br><br><br>
    <h1 id="text1" style="text-align: center;">Profile Updated Successfully!</h1>
    <br>
    <?php 
        include'../../accountsQueries.php';	
                
                $accountID=$_POST['accountID'];
                $fName=$_POST['fname'];
                $lName=$_POST['lname'];
                $DOB=$_POST['DOB'];
                $email=$_POST['email'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                $phoneNo=$_POST['phoneno'];

                
                echo
                "
                    <form action='UserViewProfile.php' method='post'>
                        <button class='viewProfilebutton' style=' width: 100px;' 
                        name='viewProfilebutton' value=$accountID type='submit'><b>Back To Profile</b></button>
                    </form>
               
                ";
                
                
                EditOwnAccount($accountID, $fName, $lName, $DOB, $email, $username, $password, $phoneNo);

    ?>
    </div>
    <br><br><br><br>
    <?php //include 'footer.php';?>
</body>
</html>