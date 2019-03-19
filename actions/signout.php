<?php 
    session_start();
    // remove all session variables
    $_SESSION = [];
    header("Location: ../index.php")
?>