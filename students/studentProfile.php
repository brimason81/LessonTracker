<!DOCTYPE html>
<!--
    TO DO:

    - Pull and display multiple images from DB
    - Create video table
    - Accept multiple extensions for lesson_image table
    
    3/7/2021
    - WORK ON PDF DISPLAY

-->
<?php
        include '../functions/functions.php';
        
        session_start();
        if (!empty($_GET)) {
            $studentId = $_GET['studentId'];

            $_SESSION['studentId'] = $studentId;
        
        } else if (isset($_SESSION['studentId'])){
            $studentId = $_SESSION['studentId'];
        }   
        
        //echo $studentId;  FOR TESTING   
?>
<?php 

// VARIABLE DECLARATION
$name;
$inst;
$lessonStart;
$lessonEnd;
$phone;
$email;
$notes;

$assignments = array();
$images = array();

$teachId;

// PROMPTS
$imgSuccess = '';
$assignSuccess = '';
$dateFormat = '';



$dateNow = date('Y-m-d', strtotime('-5 hours'));
$dateWeek = date('Y-m-d', strtotime('-1 week'));
$dateMonth = date('Y-m-d', strtotime('-4 weeks'));

// QUERY STUDENT INFO FROM DB
$query = "SELECT * FROM studentinfo WHERE Student_ID = '$studentId'";
$result = mysqli_query(dbLogin(), $query);

if (!$result) {
    die ("Something's Not Right...") ; 
} else {
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $teachId = $row['Teacher_ID'];

            // FOR TESTING, IF NEEDED
            $_SESSION['studentId'] = $row['Student_ID'];
            $name = $_SESSION['firstName'] = $row['FirstName'] . " " .
                $_SESSION['lastName'] = $row['LastName'];
            //$inst = $row['Instrument'];
            $lessonStart = date('g:i', strtotime($row['LessonStartTime'])); 
            $lessonEnd = date('g:i', strtotime($row['LessonEndTime']));
            $phone = $row['Phone'];
            $email = $row['Email'];
            $notes = $row['Notes'];
        }
    } 
}

// ADD ASSIGNMENT TO DATABASE 
if (isset($_POST['assignment'])) {
    $assignment = mysqli_real_escape_string(dbLogin(), $_POST['assignment']);
    
    $assignQuery = "INSERT INTO assignments (Student_ID, Teacher_ID, Date, Assignment) VALUES
        ('$studentId', '$teachId', '$dateNow', '$assignment')";

    $assignResult = mysqli_query(dbLogin(), $assignQuery);

    if (!$assignResult) {
        die('assignment table fail');
    } else {
        $assignSuccess = "Assignment Added!";
    }
    
}

// UPLOAD ITEMS TO lesson_images TABLE 
if (isset($_POST['uploadImg']) && ($_FILES['img']['name'] != '')) {
    
    $img = $_FILES['img']['name'];
    $studentId = $_SESSION['studentId'];

    $query = "INSERT INTO lesson_images (Student_ID, Image, LessonDate) VALUES (
        '$studentId', '$img', '$dateNow')";

    $result = mysqli_query(dbLogin(), $query);
    
    if (!$result) {
        echo die('something went wrong');
    } else {
        $imgSuccess = "Image Succesfully Uploaded!";
        
        move_uploaded_file($_FILES['img']['tmp_name'], $img);
    }
}

// QUERY ASSIGNMENT FROM DATABASE
$assignViewQuery = "SELECT * FROM assignments WHERE Student_ID = '$studentId' AND Date >= '$dateWeek'";

$assignViewResult = mysqli_query(dbLogin(), $assignViewQuery);

if (!$assignViewResult) {
    die('Assignment Query Failed');
} else {
    while($row = mysqli_fetch_assoc($assignViewResult)) {
        $assignments[] = $row['Assignment'];
    }
}

// CODE TO RETRIEVE IMAGE FROM lesson_Images TABLE
$retrieve = "SELECT * FROM lesson_images WHERE Student_ID = '$studentId' AND LessonDate >= '$dateWeek'"; //";

$imgResult = mysqli_query(dbLogin(), $retrieve);

$output = "";

if (!$imgResult) {
    echo $output .= "There are no records for this query";
} else {
    while ($row = mysqli_fetch_assoc($imgResult)) {
        $images[] = $row['Image'];        
    }
}

?>
<html>
<head>
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:wght@300&display=swap">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <div class="main-container">

        <!--OPEN GRID CONTAINER-->
        <div class="grid-container"> <!--THIS CAUSES UNIFORMITY IN HEIGTH AND WIDTH, AND ADDS TAB ON TOP OF .container-header-->
            
            <!--NAVIGATION - MAYBE PUT THIS IN GRID?-->
            <ul id="profileNav">
                <li><a href="editStudent.php">EDIT INFO</a></li>    
                <li><a href="../logout.php">LOGOUT</a></li> 
                <li><a href="addStudent.php">ADD STUDENT</a></li> 
                <li><a href="../teachers/teacherProfile.php">MY PROFILE</a></li>
            </ul>
 
        
            <!--ASSIGNMENTS CONTAINER-->
            <div class=container-assignments>
                <div class=container-header id="new-header-color">STUDENT ASSIGNMENTS</div>
                    
                    <?php 
                        foreach($assignments as $assignment) {
                            echo "<div class=\"assignments\">" . $assignment . "</div>";
                        }
                    ?>
                    <?php
                        foreach($images as $image) {
                            echo "<div class=\"assignments\" id=\"images\"><a href=\"$image\">$image</a></div>";
                            
                            /*  FOR TESTING:
                                echo "<div class=\"assignments\"><embed src=$image width=\"auto\" height=\"auto\" type=\"application/pdf\"></div>";
                            */
                        }
                    ?>
                <div class="container-footer"></div>
            </div>

            
            <!--STUDENT INFO CONTAINER-->
            <div class="container-studentInfo" >
                <div class="container-header"></div>
                    <h1><?php echo $name?></h1>
                     <h3 class="new-color"><?php echo 'Drum Set' //$inst ?></h3>
                     <p class="new-color"><?php echo $lessonStart . " - " . $lessonEnd . "<br>";
                        echo $phone . "<br>";
                        echo $email . "<br>";
                        echo $notes . "<br>";
                        ?>
                    </p>
                <div class="container-footer"></div>
            </div>

            <!--FORM TO ADD ASSIGNMENT TO DB-->
            <div class="container-add">
                <div class="container-header"><h2>ADD ASSIGNMENT</h2></div>
                    <form action="studentProfile.php" method="post">
                        <input type="text" name="assignment" placeholder="Enter Assignment">
                        <input type="submit" value="ADD ASSIGNMENT">
                    </form> 
                <div class="container-footer">
                    <?php
                        if ($dateFormat != '') {
                            echo $dateFormat;
                        } 
                        if ($assignSuccess != '') {
                            echo $assignSuccess;
                        }
                    ?>
                </div>
            </div>

        
       
            <!--FORM TO ADD LESSON IMAGES TO DB -->
            <div class="container-image-add">
                <div class="container-header"><h2>UPLOAD LESSON IMAGE</h2></div>
                    <form action="studentProfile.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="img">
                        <input type="submit" name="uploadImg" value="UPLOAD IMAGE">
                    </form>
                <div class="container-footer">
                    <?php 
                        if ($imgSuccess != '') {
                            echo $imgSuccess; 
                        }   
                    ?>
                </div>
            </div>
            
            <!-- FORM TO VIEW STUDENT LESSONS FROM lesson_images-->
            <div class="container-image-view">
                <div class="container-header"><H2>VIEW OLDER <br> ASSIGNMENTS</H2></div>
                    <form action="studentProfile.php" method="post">
                        <div class="select">
                        <select name="date" id="">
                            <option value="<?php echo $dateNow; ?>"><?php echo $dateNow; ?></option>
                            <option value="<?php echo $dateWeek; ?>"><?php echo $dateWeek; ?></option>
                            <option value="<?php echo $dateMonth; ?>"><?php echo $dateMonth;?></option>
                        </select>
                        </div>                
                        <input type="submit" name="getImages" value="SUBMIT">
                    </form>
                <div class="container-footer"></div>
            </div>

            <!--PLACEHOLDER CONTAINER-->
            <div class="container-placeholder">
                <div class="container-header"></div>
                <div class="container-footer"></div>
            </div>

        <!--CLOSE GRID FOR ASSIGNMENTS, INFO, AND ADD ASSIGNMENTS-->
        </div>

    <!--CLOSE MAIN CONTAINER-->
    </div>    
</body>
</html>