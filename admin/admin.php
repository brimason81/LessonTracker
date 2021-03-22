<?php
    include "../functions/functions.php";
    include "adminFunctions.php";

    session_start();
    $id = $_SESSION['id'];

    // TEACHER QUERY
    $queryT = "SELECT * FROM teachers";
        
    $resultT = mysqli_query(dbLogin(), $queryT);

    // STUDENT QUERY
    $queryS = "SELECT * FROM studentinfo";

    $resultS = mysqli_query(dbLogin(), $queryS);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/main.css">
    <title>Admin Page</title>
</head>
<body>

    <h3>TEACHERS</h3>
    <table width="600px" border="1" cellpadding="1" cellspacing="1">
        <tr>
            <th>Teacher_ID</th><th>FirstName<th>LastName</th><th>UserName</th>
            <th>StartDate</th><th>Phone</th><th>Email</th>
        </tr>
        
        <?php
            
            while ($row = mysqli_fetch_assoc($resultT)) {
                echo "<tr>";
                    echo "<td>" . $row['Teacher_ID'] . "</td>";
                    echo "<td>" . $row['FirstName'] . "</td>";
                    echo "<td>" . $row['LastName'] . "</td>";
                    echo "<td>" . $row['UserName'] . "</td>";
                    echo "<td>" . $row['StartDate'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                echo "</tr>";
            }
            
        ?>
    </table>

    <h3>STUDENTS</h3>
    <table width="600px" border="1" cellpadding="1" cellspacing="1">
    <tr>
        <th>Student_ID</th><th>FirstName<th>LastName</th><th>Teacher_ID</th>
        <th>StartDate</th><th>Phone</th><th>Email</th>
    </tr>
        
        <?php
            
            while ($row = mysqli_fetch_assoc($resultS)) {
                echo "<tr>";
                    echo "<td>" . $row['Student_ID'] . "</td>";
                    echo "<td>" . $row['FirstName'] . "</td>";
                    echo "<td>" . $row['LastName'] . "</td>";
                    echo "<td>" . $row['Teacher_ID'] . "</td>";
                    echo "<td>" . $row['DateStarted'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                echo "</tr>";
            }
            
        ?>
    </table>


        

</body>
</html>
