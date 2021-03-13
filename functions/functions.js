/**
 * THESE FUNCTIONS IDN'T WORK WITH VARIABLES - NOT SURE WHY
 * 
 */

// FUNCTION TO VERIFY THAT PASSWORDS MATCH
function passCheck() {
    if (document.getElementById('pass').value == document.getElementById('passMatch').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = "It\'s a Match!";
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = "Not Matching";
    }
    
    
}

// FUNCTION TO HIDE OR SHOW PASSWORD
function showPass() {
    
    if (document.getElementById('pass').type === "password") {
        document.getElementById('pass').type = "text";
        document.getElementById('passMatch').type = "text";
    } else {
        document.getElementById('pass').type = "password";
        document.getElementById('passMatch').type = "password";
    }
}

