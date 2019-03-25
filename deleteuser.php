<?php
    $validUser = false;
    session_start();
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validUser = true;
        }
    }

    if($validUser){

        $userID = filter_input(INPUT_GET, "userid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        require "actions/connect.php";
    
        $query = $db -> prepare("DELETE FROM users WHERE UserID = '$userID'");
        $query -> execute();

        header("location: admin.php");

    } else {
        header("location: index.php");
    }
?>