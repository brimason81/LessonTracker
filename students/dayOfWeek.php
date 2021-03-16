<?php
	include '../functions/functions.php';
	session_start();
	$teachId = $_SESSION['id'];
?>
<?php
        
	$day = $_GET['days'];
	$query = "SELECT * FROM studentinfo WHERE LessonDay = '$day' AND Teacher_ID = '$teachId'"; 
    $result = mysqli_query(dbLogin(), $query); 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300&display=swap">

	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/table.css">
    <title>Day View</title>
</head>
<body>
	<div class="main-container">
		
		<!--NAVIGATION-->
		<ul>
			<li><a href="../teachers/teacherProfile.php">My Profile</a></li>
			<li><a href="addStudent.php">Add Student</a></li>
		</ul>

		<table>
			<tr>
				<td>STUDENT ID</td>
				<td>STUDENT NAME</td>
				<td>LESSON TIME</td>
			</tr>
			<?php
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";	
							echo "<td><a href=\"studentProfile.php?studentId=". $row['Student_ID'] . "\"  >". $row['Student_ID'] . "</a></td>" . " "; 
							echo "<td>" . $row['FirstName'] . ' ' . $row['LastName'] . "</td>" . " ";
							echo "<td>" .  date('g:i', strtotime($row['LessonStartTime'])) . " - " . date('g:i', strtotime($row['LessonEndTime'])) . "</td><br>" . " ";
						echo "</tr>";
					}
				} else {
					echo "You do not have any students on this day.";
				}
			?>
		</table>
		
	</div>
</body>
</html>