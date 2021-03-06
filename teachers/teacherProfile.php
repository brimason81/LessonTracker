<?php
    /*
        TO DO:

        -FIX INSTRUMENTS IN DATABASE
            - LINE 33 & 88
    
    */

    session_start();
    if (isset($_SESSION['delete'])) {
        $deletedStudent = $_SESSION['delete'];
    }
    
    // FDBCK - FIX SO DOESN'T DISPLAY AFTER FIRST VIST BACK TO PROFILE - $_GET??
    echo $deletedStudent;

    include '../functions/functions.php';
?>
<?php

    // VARIABLES
    $result;
    
    $adminId = 74;

    // PROMPTS
    $noStudentsPrompt = '';
    
    //  QUERY DB FOR ALL STUDENTS
    if (!empty($_SESSION)) {

        $id = $_SESSION['id'];
        
        $query = "SELECT * FROM studentinfo WHERE Teacher_ID = '$id'";
        $result = mysqli_query(dbLogin(), $query);

        if (!$result)  {
            die('Query Failed');
        } else if (!mysqli_num_rows($result) > 0) {
            $noStudentsPrompt = 'You Do Not Have Any Students in the Database!' . '<br>' .  
            'Please Click \'Add Student\' To Add Student';
        }
    }

    /*QUERY DB FOR TODAY'S LESSONS
    $today = date('l', strtotime('-5 hours'));
    $dailyLessonQuery = "SELECT * FROM studentinfo WHERE Teacher_ID = '$id' AND LessonDay = '$today'";
    $dailyLessonResult = mysqli_query(dbLogin(), $dailyLessonQuery);

    if (!$dailyLessonResult) {
        die ('Cannot Retrieve Today\'s Lessons.');
    } else {
        if (mysqli_num_rows($dailyLessonResult) > 0) {
            while ($row = mysqli_fetch_assoc($dailyLessonResult)) {
                echo $row['FirstName'] . " ";
                echo $row['LastName'] . " ";
                //echo $row['Instrument'] . " "; 
                echo date('g:i', strtotime($row['LessonStartTime'])) . " - " . date('g:i', strtotime($row['LessonEndTime'])) . "<br>";
            }
        } else {
            
        }
    }*/
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300&display=swap">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/table.css">
    <title>Teacher Profile</title>
</head>
<body>
    <div class="main-container">
        <div class="grid-container-teach">
        
            <!--NAVIGATION-->
            <ul>    <!--onclick="dbLogout()" -- THIS DOESN'T WORK--->
                <li><a href="../logout.php">LOGOUT</a></li>
                <li><a href="../students/addStudent.php">ADD STUDENT</a></li> 
                <li><a href="editTeacher.php">EDIT MY PROFILE</a></li> 
                
                <!--ONLY DISPLAY ON ADMIN LOGIN-->
                <?php
                    if ($id == $adminId) {
                        echo "<li><a href=\"../admin/admin.php\">view database info</a></li>";
                    }
                ?>
            </ul>     
        
            <h1>Welcome, <span><?php echo $_SESSION['user'] . '!'?></span></h1>
                    
            <table class="students"><!-- ALL LESSONS-->
               <tr id="top-row">
                   <td>STUDENT NAME</td>
                   <td>LESSON TIME</td>
                   <td>LESSON DAY</td>
               </tr>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";  
                                echo "<td>" . $row['FirstName'] . " " .  $row['LastName'] . "</td> ";
                                //echo $row['InstrumentName'] . " "; 
                                echo "<td>" . date('g:i', strtotime($row['LessonStartTime'])) . " - " . date('g:i', strtotime($row['LessonEndTime'])) . "</td> ";
                                echo "<td>" . $row['LessonDay'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                            echo "<td>" . $noStudentsPrompt . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>

            <!--FORM TO SELECT DAY OF WEEK-->
            <form action="../students/dayOfWeek.php">
                <div class="container-studentInfo">
                    <div class="container-header"><h2>Select a Day for Day View</h2></div>
                    <!--DROP DOWN MENU FOR DAY OF WEEK VIEW-->
                    
                        <select name="days" id="days">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select> 

                    <!--SUBMIT FOR DAY VIEW FORM-->
                    <div class="container-footer"><input type="submit"></div>
                </div>
            </form>  

        <!--CLOSE GRID CONTAINER-->
        </div>
    </div>    
</body>
</html>