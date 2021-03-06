<?php

/**
 * TO DO:
 * 
 * - instruments():  Array not working - does not contain all columns 
 * 
 */
        
    // FUNCTION TO LOGIN TO DB
    function dbLogin() {
        
        // DB VARIABLES - THIS FUNCTION DID NOT WORK WHEN VARIABLES WERE OUTSIDE OF THE FUNCTION
        $username = "root";
	    $password = "";
	    $db = "Students";
	    $server = "localhost";
        
        $db_server = mysqli_connect($server, $username, $password);
        mysqli_select_db($db_server, $db);
        return $db_server;
    }

    // FUNCTION UPDATE DATA IN studentinfo TABLE
    function updateInfo($column, $varTwo, $id) { 
		
		$query = "UPDATE studentinfo SET $column = '$varTwo' WHERE Student_ID = '$id'"; 
        $result = mysqli_query(dbLogin(), $query);
        
		if (!$result) {
			die ("No");
		} else {
			$row[$column] = $varTwo;
			echo "Updated!";
		}		
	}

    // VADLIDATE DATE FORMAT
	function valiDate($date) {
        $format = 'Y-m-d';
        if ($tempDate = DateTime::createFromFormat($format, $date)) {
            return true;
        } else {
            return false;
        }
	}

    // VALIDATE LESSON TIME 
    function validateTime($time) {
        $formatTime = 'g:i';
        if ($tempTime = DateTime::createFromFormat($formatTime, $time)) {
            return true;
        } else {
            return false;
        }
    }

    // VALIDATES PHONE NUMBER FORMAT
    function validatePhone($phone) {
        $format = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
        return preg_match($format, $phone);
    }

    // VALIDATES EMAIL FORMAT 
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateSignUpForm($array) {
        
    }

    // CHECKS IF USERNAME ALREADY EXISTS IN DATABASE
    function uniqueUser($userName) {
        
        // query database for username
        $query = "SELECT * FROM Teachers WHERE UserName = '$userName'";
        $result = mysqli_query(dbLogin(), $query);
        
        if (mysqli_num_rows($result) > 0) {
            return false;
        } else {
            return true;
        }
    }

    // RETURNS A GIVEN TEACHER'S INSTRUMENTS TAUGHT FOR A DROP DOWN MENU
    function instruments($teachId) {
        
        $query = "SELECT InstrumentName FROM Instruments WHERE Teacher_ID = '$teachId'";
		$result = mysqli_query(dbLogin(), $query);

        $instArray;
        
		if (!$result) {
			die ('Not able to access teacher info');
		} else {
            
            // POPULATE ARRAY
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                $instArray[$i] = $row[0];
                $i++;
            }
        }
    return $instArray;
	}
    
    // FUNCTION TO PARSE $_POST INPUT FROM students.php
    function studentPostParse ($post) {
        // code    
    }

    // FUNCTION TO CREATE SALT - NOT NECESSARY??
    function passwordSalt() {
        $options = [
            'cost' => 11,
            'salt' => openssl_random_pseudo_bytes(22, $cstrong),
        ];
        
        return $salt = $options['salt'];
    }

    // FUNCTION TO CREATE PASSWORD HASH - COULD BE USED TO GENERATE OWN SALT??
    function passwordHash($password) {
        $options = [
            'cost' => 11,
            'salt' => openssl_random_pseudo_bytes(22, $cstrong),
        ];

        return $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    }


?>