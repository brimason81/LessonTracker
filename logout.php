<?php
    // MOVE TO FUNCTIONS PG
    
    session_start();
    session_destroy();
    header("location:  index.php");
?>