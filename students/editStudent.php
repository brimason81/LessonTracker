<?php
	/*
		TO DO

		-FIX INSTRUMETS UPDATE
		-FIX USER FEEDBACK
	
	*/

	include '../functions/functions.php';
	session_start();

	$id = $_SESSION['studentId'];
	$instArray;
?>
<?php
	
	// PROMPTS
	$badPhone = $badEmail = $badTime = '';
	
	// DB QUERY
	$query = "SELECT * FROM studentinfo WHERE Student_ID = '$id'";

	$result = mysqli_query(dbLogin(), $query);
	
	if(!$result) {
		die("NOOOOO");
	} else {

		$rows = mysqli_num_rows($result); 
		$row = mysqli_fetch_assoc($result);

		$teachId = $row['Teacher_ID'];
		$instArray = instruments($teachId);
	}

	if (!empty($_POST)) {
		
		if (isset($_POST['fName']) && ($_POST['fName'] !== '')) {
			$fName = mysqli_real_escape_string(dbLogin(), $_POST['fName']);
			updateInfo('FirstName', $fName, $id);
		}; 
		
		if (isset($_POST['lName']) && ($_POST['lName'] !== '')) {
			$lName = mysqli_real_escape_string(dbLogin(), $_POST['lName']); 
			updateInfo('LastName', $lName, $id);
		}	
		
		if (isset($_POST['phone']) && ($_POST['phone'] !== '')) {
			$phone = mysqli_real_escape_string(dbLogin(), $_POST['phone']); 

			if (validatePhone($phone)) {
				updateInfo('Phone', $phone, $id);
			} else {
				$badPhone = "Please Enter a Valid Phone Number (555-555-5555)";
			}
		}
		
		if (isset($_POST['email']) && ($_POST['email'] !== '')) {
			$email = mysqli_real_escape_string(dbLogin(), $_POST['email']); 
			
			if (validateEmail($email)) {
				updateInfo('Email', $email, $id);
			} else {
				$badEmail = "Please Enter Valid Email Address";
			}
		}
 		
		if (isset($_POST['startTime']) && ($_POST['startTime'] !== '')) { 
			$time = mysqli_real_escape_string(dbLogin(), $_POST['startTime']); 
			
			if (validateTime($time)) {
				updateInfo('LessonStartTime', $time, $id);
			} else {
				$badTime = "Please Use the Correct Format for Start Time (HH:MM)";
			}
		}
 		
		if (isset($_POST['endTime']) && ($_POST['endTime'] !== '')) { 
			$time = mysqli_real_escape_string(dbLogin(), $_POST['endTime']); 
			
			if (validateTime($time)) {
				updateInfo('LessonEndTime', $time, $id);
			} else {
				$badTime = 'Please Use the Correct Format for End Time (HH:MM)';
			}
		}
		
		if (isset($_POST['days']) && ($_POST['days'] !== '')) { 
			$day = mysqli_real_escape_string(dbLogin(), $_POST['days']); 
			updateInfo('LessonDay', $day, $id);
		}
		
		if (isset($_POST['insts']) && ($_POST['insts'] !== '')) { 
			$inst = mysqli_real_escape_string(dbLogin(), $_POST['insts']); 
			updateInfo('Instrument', $inst, $id);
		}	
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Student Edit</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300&display=swap">
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/formStyle.css">
</head>
	<body>

	<!--MAIN CONTAINER OPEN-->
	<div class="main-container">
		
		<!--NAVIGATION-->
		<ul>
			<li><a href="studentProfile.php">STUDENT PROFILE</a></li>
			<li><a href="../teachers/teacherProfile.php">MY PROFILE PAGE</a></li>
		</ul>
		
		<form method="post" action="editStudent.php">
			<div class="container" id="edit">
				<div class="container-header" id="edit-head"><h2>EDIT INFO FOR<span> <?php 
					echo "<br>" . $row['FirstName'] . " " . $row['LastName'];
						?></span></h2></div>
			
					<!--this doesn't update on Submit when variables are used in method; updates on the following Submit-->
					<input type="text" placeholder="First Name" name="fName">
					<input type="text" placeholder="Last Name" name="lName">

					<input type="text" placeholder="555-555-5555" name="phone">
					<!--FEEDBACK-->
					<?php if ($badPhone != '') echo $badPhone;?>

					<input type="text" placeholder="email@domain.com" name="email">
					<!--FEEDBACK-->
					<?php if ($badEmail != '') echo $badEmail;?>

					<!--TIME - ADD A.M. P.M. -->
					<input type="text" placeholder="00:00" name="startTime">
					<!--FEEDBACK-->
					<?php if ($badTime != '') echo $badTime;?>
					<input type="text" placeholder="00:00" name="endTime">
					<!--FEEDBACK-->
					<?php if ($badTime != '') echo $badTime;?>
					
					<label for="">LESSON DAY</label>
					<select name="days" id="days">
						<option value=""></option>
						<option value="Monday">Monday</option>
						<option value="Tuesday">Tuesday</option>
						<option value="Wednesday">Wednesday</option>
						<option value="Thursday">Thursday</option>
						<option value="Friday">Friday</option>
						<option value="Saturday">Saturday</option>
						<option value="Sunday">Sunday</option>
					</select>

					<!--NEED TO FIX instruments TABLE BEFORE THIS WILL WORK-->
					<label for="">INSTRUMENT</label>
					<select name="insts" id="insts">
						<option value=""></option>
						<?php
							for ($i = 0; $i < sizeof($instArray); $i++ ) {
								echo "<option value=\'$instArray[$i]\'>$instArray[$i] </option>";
							}	
						?>
					</select>
					<input type="submit" value="Submit">
				<div class="container-footer"></div>	
			</div>		
		</form>
		<!--MAIN CONTAINER CLOSE-->
	</div>
	</body>
</html>