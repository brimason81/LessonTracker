<!DOCTYPE html>
<!--
	TO DO:

	- FIX AM/PM
	
	
-->
<?php
	include '../functions/functions.php';

	session_start();
	$teachId = $_SESSION['id'];
	
	// CALL(S) TO functions.php
	$instArray = instruments($teachId);
	$studentId;
?>

<?php

	// VARIABLE DECLARATION
	$twelveHourAdjust = 43200;
	$placeholderDate = date('Y-m-d', strtotime('-5 hours'));

	// PROMPTS/FEEDBACK
	$emailFormat = '';
	$dateFormat = '';
	$timeFormat = '';
	$phoneFormat = '';
	
	// $_POST VARIABLE ASSIGNMENT
	if (isset($_POST['fName']))  $fName = mysqli_real_escape_string(dbLogin(), $_POST['fName']);
	if (isset($_POST['lName']))  $lName = mysqli_real_escape_string(dbLogin(), $_POST['lName']);
	if (isset($_POST['notes']))  $notes = mysqli_real_escape_string(dbLogin(), $_POST['notes']);

	// POST VARIABLES THAT REQUIRE FORMAT VALIDATION
	if (isset($_POST['phone']))  $phone = mysqli_real_escape_string(dbLogin(), $_POST['phone']);
	if (isset($_POST['email'])) $email = mysqli_real_escape_string(dbLogin(), $_POST['email']);
	if (isset($_POST['date'])) $date = mysqli_real_escape_string(dbLogin(), $_POST['date']); 
		
	// TIMES
	if (isset($_POST['startTime']) && isset($_POST['endTime'])) {
		$startTime = $_POST['startTime'];
		$endTime = $_POST['endTime'];

		// A.M. and P.M for TIME - maybe add to validateTime()?
		if ($_POST['mornNightStart'] == 'pm') {
			$startTime = date('g:i', strtotime($startTime) + $twelveHourAdjust);
		} 
		
		if ($_POST['mornNightEnd'] == 'pm') {
			$endTime = date('g:i', strtotime($endTime) + $twelveHourAdjust);
		} 
		
	}

	if (isset($_POST['days']))  $day = $_POST['days'];
    if (isset($_POST['insts']))  $inst = $_POST['insts'];
	
	// VALIDATE USER INPUT
	if (!empty($_POST)) {
		if (!validateEmail($email)) {
			$emailFormat = 'Please Enter A Valid Email Address';
		} else if (!validatePhone($phone)) {
			$phoneFormat = 'Please Enter A Valid Phone Number (555-555-5555)';
		} else if (!valiDate($date)) {
			$dateFormat = "Please Use The Correct Format For Date (YYYY-MM-DD)";
		} else if (!validateTime($startTime) || !validateTime($endTime)) {
			$timeFormat = "Please Use The Correct Format For Time (HH:MM)";
		} else {
			$query = "INSERT INTO studentinfo (FirstName, LastName, Phone, Notes, DateStarted, LessonStartTime, LessonEndTime, LessonDay, Email, Teacher_ID) 
				VALUES ('$fName', '$lName', '$phone', '$notes', '$date', '$startTime', '$endTime', '$day', '$email', '$teachId')";
			$result = mysqli_query(dbLogin(), $query);
			
			if (!$result) {
				die("Didn't work");
			} /**/else {
				
				$idQuery = "SELECT * FROM studentinfo WHERE Email = '$email'";

				$idResult = mysqli_query(dbLogin(), $idQuery);

				while ($row = mysqli_fetch_assoc($idResult)) {
					$studentId = $row['Student_ID'];
				}

			}

			$instQuery = "INSERT INTO instruments (InstrumentName, Teacher_ID, Student_ID)
				VALUES ('$inst', '$teachId', '$studentId')";
			
			$instResult = mysqli_query(dbLogin(), $instQuery);

			if (!$instResult) {
				die("Instrument Table Fail");
			}

		}
	}	
?>
<html>
<head>
	<title>Add Student Page</title>
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300&display=swap">
	<link rel="stylesheet" href="../css/formStyle.css">
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<div class="main-container">	
		
		<!--NAVIGATION-->
		<ul>
			<li><a href="../teachers/teacherProfile.php">MY PROFILE</a></li>
			<li><a href="../logout.php">LOGOUT</a></li>
		</ul>

		<!--ADD STUDENT FORM-->
		<form method="post" action="addStudent.php">
			<div class="grid-container">
				<div class="container">
					<div class="container-header"></div>
						
						<!--STUDENT INFO-->
						<input id="info" type="text" name="fName" placeholder="First Name" required="required">
						<input id="info" type="text" name="lName" placeholder="Last Name" required="required">
						
						<input id="info" type="text" name="date" placeholder="<?php echo $placeholderDate; ?>" required="required">
							
							<!--FEEDBACK-->
							<?php if ($dateFormat != '') echo $dateFormat?>
							
						<input id="info" type="text" name="phone" placeholder="555-555-5555" required="required">

							<!--FEEDBACK-->
							<?php if ($phoneFormat != '') echo $phoneFormat?>

						<input id="info" type="text" name="email" placeholder="email@domain.com" required="required">

							<!--FEEDBACK-->
							<?php if ($emailFormat != '') echo $emailFormat?>

					<div class="container-footer"></div>
				</div>

				<div class="container">
					<div class="container-header"></div>
						<input id="info" type="text" name="startTime" placeholder="Enter Lesson Start Time" required="required"><br>
						
						<!--FEEDBACK-->
						<?php if ($timeFormat != "") echo $timeFormat ?>
						
						<input type="radio" name="mornNightStart" value="am" checked="checked"> <span> AM</span>
						<input type="radio" name="mornNightStart" value="pm"> <span> PM</span><br>
						
						<input id="info" type="text" name="endTime" placeholder="Enter Lesson End Time" required="required"><br>
						
						<!--FEEDBACK-->
						<?php if ($timeFormat != "") echo $timeFormat ?>

						<input type="radio" name="mornNightEnd" value="am" checked="checked"> <span> AM</span>
						<input type="radio" name="mornNightEnd" value="pm"> <span> PM</span>
					<div class="container-footer"></div>
				</div>

				<div class="container">
					<div class="container-header"></div>
						<label for=""> Select A Lesson Day</label>
							<select name="days" id="days" required="required">
								<option value=""></option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
								<option value="Sunday">Sunday</option>
							</select>
						<label for=""> Select An Instrument</label>
						
						<?php

						// DROP DOWN OF Instruments FROM DB
						echo "<select name=\"insts\" id=\"insts\" required=\"required\">";
							echo "<option value=\"\"></option>";
							for ($x = 0; $x < sizeof($instArray); $x++) {
								echo "<option value=\'$instArray[$x]\'>$instArray[$x]</option>";
							}
						echo "</select>";
						
						?>

						<textarea name="notes" placeholder="Enter Any Important Notes About Student"></textarea>

						<!--SUBMIT BUTTON-->
						<input id="btn" type="submit" value="Submit">

					<div class="container-footer"></div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>