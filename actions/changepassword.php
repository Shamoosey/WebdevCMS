<?php
//check if the password is posted
if(isset($_POST["password"])){
    //does the password contain anything
    if($_POST["password"] != ""){

        //filter the user inputs
        $newpass = filter_input(INPUT_POST, "password" ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userID = filter_input(INPUT_POST, "userid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        require "connect.php";

        //hash the new password
        $hashedPass = password_hash($newpass, PASSWORD_DEFAULT);

        //query the db
        $query = $db -> prepare("UPDATE users SET Password = '$hashedPass' WHERE UserID = '$userID'");
        $query -> execute();

        //redirect the user
        header("location: ../selectuseradmin.php?userid=$userID");
    } else {
        header("location: ../admin.php?error=1");
    }
} else {
    header("location: ../admin.php?error=1");
}
?>