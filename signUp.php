<?php
    include 'functions.php';
?>
<?php

    // POST Variables
    if (isset($_POST['userName'])) $userName = mysqli_real_escape_string(dbLogin(), $_POST['userName']);
    if (isset($_POST['fName'])) $fName = mysqli_real_escape_string(dbLogin(), $_POST['fName']); 
    if (isset($_POST['lName'])) $lName = mysqli_real_escape_string(dbLogin(), $_POST['lName']);
    
    // VALIDATE PHONE NO.
    if (isset($_POST['phone'])) {
        if (validatePhone($_POST['phone'])) {
            $phone = mysqli_real_escape_string(dbLogin(), $_POST['phone']); 
        } else {
            echo 'Please Enter A Valid Phone Number (555-555-5555)';
        }
    }    

    // VALIDATE EMAIL
    if (isset($_POST['email'])) {
        if (validateEmail($_POST['email'])) {
            $email = mysqli_real_escape_string(dbLogin(), $_POST['email']); 
        } else {
            echo '<br>' . 'Please Enter A Valid Email Address';
        }    
    } 

    // Array POST Variables
    if (isset($_POST['instruments'])) $instruments =  $_POST['instruments'];
    
    // Password and Validation
    if (isset($_POST['pass'])) $pass = mysqli_real_escape_string(dbLogin(), $_POST['pass']); 
    if (isset($_POST['passMatch'])) $passMatch = mysqli_real_escape_string(dbLogin(), $_POST['passMatch']); 

    if (!empty($_POST)) {
        
        // VALIDATE UNIQUE USERNAME 
        if (!uniqueUser($userName)) {
            echo 'That User Name Already exists in the Database';
        } else {

            $hashPass = passwordHash($pass);
            $salt = passwordSalt();

            $query = "INSERT INTO Teachers (FirstName, LastName, UserName, Phone, Email, Password, Salt) 
                VALUES ('$fName', '$lName', '$userName', '$phone', '$email', '$hashPass', '$salt')";

            $result = mysqli_query(dbLogin(), $query);

            if (!$result) {
                die("Query Failed.");
            } else {
                
                $newQuery = "SELECT * FROM Teachers WHERE Password = '$hashPass'";
                $newResult = mysqli_query(dbLogin(), $newQuery);

                session_start();
                
                $teachId;

                if (mysqli_num_rows($newResult) > 0) {
                    while ($row = mysqli_fetch_assoc($newResult)) {
                        
                        $teachId = $row['Teacher_ID'];
                        
                        // SET SESSION VARIABLES
                        $_SESSION['id'] = $row['Teacher_ID'];
                        $_SESSION['firstName'] = $row['FirstName']; 
                        $_SESSION['user'] = $row['UserName'];
                    }
                }
                
                // POPULATE Instruments TABLE
                for ($x = 0; $x < sizeof($instruments); $x++) {
                    $inst = $instruments[$x];
                    
                    $instQuery = "INSERT INTO Instruments (InstrumentName, Teacher_ID)
                        VALUES ('$inst', '$teachId')";

                    $instResult = mysqli_query(dbLogin(), $instQuery);

                    if (!$instResult) {
                        die("Instruments Table Fail.");
                    } else {
                        header('location:  teacherProfile.php');
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="functions.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=., initial-scale=1.0">
    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        @import url('https://googleapis.com/css?family=Ubuntu:wght@300&display=swap');
    </style>
    <title>Teacher Registration/Login</title>
</head>
<body>
    <div class="main-container">
        <!--NAVIGATION-->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="teacherLogin.php">Login</a></li>
            <!--ONLY DISPLAY ON ADMIN LOGIN-->
            <li><a href="">view database link on Admin login</a></li>
        </ul>
        
        <h3>Sign Up For Lesson Tracker</h3>
        
        <!-- FORM FOR TEACHER REGISTRATION -->
        <form method="post" action="signUp.php">
            <div class="grid-container">
                <div class="container">
                    <div class="container-header"><p>Enter Your Info</p></div>
                        <!--Personal Info Enter-->
                        <input type="text"name="fName" placeholder="First Name" required="required">
                        <input type="text"name="lName" placeholder="Last Name" required="required"> 
                        <input type="text" name="userName" placeholder="User Name" required="required">
                        <input type="text"name="phone" placeholder="Phone Number" required="required"> 
                        <input type="text"name="email" placeholder="Email" required="required"> 
                    <div class="container-footer"></div>
                </div>    
                        
                <div class="container">
                    <div class="container-header"><p>Select Instruments To Teach</p></div>
                        <!--Instrument Select-->
                        <!--<label>Please Select the Instruments That You Teach</label><br>-->
                        <input type="checkbox" name="instruments[]" value="Drum Set" ><span> Drum Set</span><br>
                        <input type="checkbox" name="instruments[]" value="Electric Bass" ><span> Electric Bass</span><br>
                        <input type="checkbox" name="instruments[]" value="Guitar" ><span> Guitar</span><br>
                        <input type="checkbox" name="instruments[]" value="Piano" ><span> Piano</span><br>
                        <input type="checkbox" name="instruments[]" value="Ukulele" ><span> Ukulele</span>
                    <div class="container-footer"></div>
                </div>   

                <div class="container">
                    <div class="container-header"><p>Enter Password</p></div>
                        <!--Password Enter-->
                        <input type="password" name="passMatch" id="passMatch" placeholder="Password" required="required" onkeyup='passCheck();'>
                        <input type="password" name="pass" id="pass" placeholder="Confirm Password" required="required" onkeyup='passCheck();'><br>
                        <p id="message"></p>

                        <!--SUBMIT BUTTON-->
                        <input type="submit" value="SUBMIT" >
                        
                        <!--SHOW PASSWORD-->
                        <input type="checkbox" onclick='showPass()'> <span>Show Password</span>
                    </div>  
                    <div class="container-footer"></div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>