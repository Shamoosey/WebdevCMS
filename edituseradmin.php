<?php
    $errorFlag = false;
    $values = ['userid', 'username', 'email', 'fname', 'lname'];
    $userFields = array();
    
    session_start();
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validUser = true;
        }
    }

    if($validUser && isset($_POST)){
        foreach ($values as $value) {
            if(isset($_POST[$value])){
                if($_POST[$value] != ""){
    
                    array_push($userFields, filter_input(INPUT_POST, $value ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
                } else {
                    $errorFlag = true;
                }
            } else {
                $errorFlag = true;
            }
        }
        if(!$errorFlag) {
            
            require "actions/connect.php";
            
            $query = $db -> prepare("UPDATE users SET Username = '$userFields[1]', Email = '$userFields[2]', 
                                                    FirstName = '$userFields[3]', LastName = '$userFields[4]' 
                                    WHERE UserID = '$userFields[0]'");
            $query -> execute();
            header("location: admin.php");
        } else {
            header("location: admin.php?error=true");
        }
    } else {
        header("location: admin.php?error=true");
    }
?>