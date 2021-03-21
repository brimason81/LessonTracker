<?php 
    include "../functions/functions.php";
    session_start();

    $id = $_SESSION['id'];
?>

<?php
    
    // PROMPTS/FEEDBACK
    $updateResult = $badPhone = $badEmail = '';

    // POST VALIDATION
    if (!empty($_POST)) {
        if (isset($_POST['fName']) && ($_POST['fName'] != '')) {
            $fName = mysqli_real_escape_string(dbLogin(), $_POST['fName']);
            updateTeachInfo('FirstName', $fName, $id, $updateResult);
            $updateResult = "First Name Succesfully Updated";
        }

        if (isset($_POST['lName']) && ($_POST['lName'] != '')) {
            $lName = mysqli_real_escape_string(dbLogin(), $_POST['lName']);
            updateTeachInfo('LastName', $lName, $id, $updateResult);
            $updateResult = "Last Name Succesfully Updated";
        }

        if (isset($_POST['phone']) && ($_POST['phone'] !== '')) {
			$phone = mysqli_real_escape_string(dbLogin(), $_POST['phone']); 

			if (validatePhone($phone)) {
				updateTeachInfo('Phone', $phone, $id, $updateResult);
                $updateResult = "Phone Number Succesfully Updated";
			} else {
				$badPhone = "Please Enter a Valid Phone Number (555-555-5555)";
			}
		}
		
		if (isset($_POST['email']) && ($_POST['email'] !== '')) {
			$email = mysqli_real_escape_string(dbLogin(), $_POST['email']); 
			
			if (validateEmail($email)) {
				updateTeachInfo('Email', $email, $id, $updateResult);
                $updateResult = "Email Succesfully Updated";
			} else {
				$badEmail = "Please Enter Valid Email Address";
			}
		}
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300&display=swap">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/formStyle.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>Edit Profile</title>
</head>
<body>
    <!--MAIN CONTAINER-->
    <div class="main-container">

        <!--NAVIGATION-->
        <ul>
            <li><a href="teacherProfile.php">MY PROFILE</a></li>
            <li><a href=""></a></li>
        </ul>

        <form action="editTeacher.php" method="post">
            <div class="container" id="edit">
                <div class="container-header" id="edit-head"><h2>EDIT PROFILE</h2></div>
                    
                    <!--this doesn't update on Submit when variables are used in method; updates on the following Submit-->
					<input type="text" placeholder="First Name" name="fName">
                    <!--FEEDBACK-->
                    <?php
                        if ($updateResult != '') {
                            echo $updateResult;
                        } 
                    ?>

					<input type="text" placeholder="Last Name" name="lName">
                    <!--FEEDBACK-->
                    <?php
                        if ($updateResult != '') {
                            echo $updateResult;
                        } 
                    ?>

					<input type="text" placeholder="555-555-5555" name="phone">
                    <!--FEEDBACK-->
                    <?php
                        if ($updateResult != '') {
                            echo $updateResult;
                        } elseif ($badPhone != '') {
                            echo $badPhone;
                        }
                    ?>

					<input type="text" placeholder="email@domain.com" name="email">
                    <!--FEEDBACK-->
                    <?php
                        if ($updateResult != '') {
                            echo $updateResult;
                        } elseif ($badEmail != '') {
                            echo $badEmail;
                        }
                    ?>
                
                    <input type="submit" value="SUBMIT">
                <div class="container-footer"></div>
            </div>            
        </form>
    </div>
</body>
</html>