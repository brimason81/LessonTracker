<?php
    include 'functions.php';
?>
<?php
    
    // LOGIN CREDENTIALS
    if (isset($_POST['userName'])) $userName = mysqli_real_escape_string(dbLogin(), $_POST['userName']);
    if (isset($_POST['pass'])) $pass = mysqli_real_escape_string(dbLogin(), $_POST['pass']);

    // AUTHENTICATION 
    if (!empty($_POST)) {

        // OBTAINING USER INFO
        $query = "SELECT * FROM Teachers WHERE UserName = '$userName'"; // userName
        $result = mysqli_query(dbLogin(), $query);

        if (!$result) {
            die('Unable to Access Database');
        } else {

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            }
            
            if (password_verify($pass, $row['Password'])) {
                session_start();
                $_SESSION['id'] = $row['Teacher_ID'];
                $_SESSION['user'] = $row['UserName'];
                $_SESSION['firstName'] = $row['FirstName'];
                $_SESSION['pass'] = $row['Password'];

                header('location:  teacherProfile.php');
            } else {
                echo 'Your User Name and/or Password is incorrect' . "<br>";
                echo 'Please Enter Valid Login Credentials' . "<br>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="functions.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/formStyle.css">
    <title>Teacher Login</title>
</head>
<body>
    <div class="main-container">
        <!--NAVIGATION--> 
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="signUp.php">Sign Up</a></li>
        </ul> 

        <h3>Enter Your Login Info</h3>

        <!--TEACHER LOGIN FORM-->
        <div class="container">
            <div class="container-header"></div>

            <form action="teacherLogin.php" method="post">
                <input type="text" name="userName" placeholder="Username" required="required">        
                <input type="password" name="pass" id="pass" placeholder="Password" required="required"><br>
                <input type="submit" id="submit" value="SUBMIT">
                
                <input type="checkbox" onclick="showPass();"> <span>Show Password</span> 
            </form> 

            <div class="container-footer"></div> 
        </div>
    </div>
</body>
</html>