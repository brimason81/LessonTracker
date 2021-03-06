<?php
	/*
		TO DO

		-MAKE <a> TAGS PART OF <ul> - inline...
	
	*/

	include 'functions.php';
	session_start();

	$id = $_SESSION['studentId'];
	$instArray;
?>
<?php
		
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
				echo "Please Enter a Valid Phone Number (555-555-5555)";
			}
		}
		
		if (isset($_POST['email']) && ($_POST['email'] !== '')) {
			$email = mysqli_real_escape_string(dbLogin(), $_POST['email']); 
			
			if (validateEmail($email)) {
				updateInfo('Phone', $phone, $id);
			} else {
				echo "Please Enter Valid Email Address";
			}
		}
 		
		if (isset($_POST['startTime']) && ($_POST['startTime'] !== '')) { 
			$time = mysqli_real_escape_string(dbLogin(), $_POST['startTime']); 
			
			if (validateTime($time)) {
				updateInfo('LessonStartTime', $time, $id);
			} else {
				echo "Please Use the Correct Format for Start Time (HH:MM)";
			}
		}
 		
		if (isset($_POST['endTime']) && ($_POST['endTime'] !== '')) { 
			$time = mysqli_real_escape_string(dbLogin(), $_POST['endTime']); 
			
			if (validateTime($time)) {
				updateInfo('LessonEndTime', $time, $id);
			} else {
				echo 'Please Use the Correct Format for End Time (HH:MM)';
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
	</head>
	<body>
	<form method="post" action="editStudent.php">

	<!--this doesn't update on Submit when variables are used in method; updates on the following Submit-->
	<h1>Select element to change for <span><?php echo $row['FirstName'] . " " . $row['LastName']; ?></span></h1>
	<table width="600px" border="1" cellpadding="1" cellspacing="1">
	<tr>	
		<th>First Name</th>
		<th>Last Name</th>
		<th>Phone</th>
		<th>Email</th>
		<th>Lesson Start Time </th>
		<th>Lesson End Time </th>
		<th>Lesson Day</th>
		<th>Instrument</th>		
	</tr>
	<tr>
		<td><input type="text" placeholder="First Name" name="fName"></td>
		<td><input type="text" placeholder="Last Name" name="lName"></td>
		<td><input type="text" placeholder="555-555-5555" name="phone"></td>
		<td><input type="text" placeholder="email@domain.com" name="email"></td>
		<td><input type="text" placeholder="00:00" name="startTime"></td>
		<td><input type="text" placeholder="00:00" name="endTime"></td>
		<td>
		
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

		</td>
		<td>	

			<select name="insts" id="insts">
				<option value=""></option>
				<?php
					for ($i = 0; $i < sizeof($instArray); $i++ ) {
						echo "<option value=\'$instArray[$i]\'>$instArray[$i] </option>";
					}	
				?>
			</select>

		</td>
	</tr>
	</table>	
	<input type="submit" value="Submit">
	</form>
	<p></p>
	<a href="student.php">Student Profile</a>
	<p></p>
	<a href="teacherProfile.php">My Profile Page</a>
	</body>
</html>