<?php


if(isset($_POST["password"])){
    if($_POST["password"] != ""){

        $newpass = filter_input(INPUT_POST, "password" ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userID = filter_input(INPUT_POST, "userid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        require "connect.php";

        $hashedPass = password_hash($newpass, PASSWORD_DEFAULT);

        $query = $db -> prepare("UPDATE users SET Password = '$hashedPass' WHERE UserID = '$userID'");
        $query -> execute();

        header("location: ../selectuseradmin.php?userid=$userID");
    } else {
        header("location: ../index.php");
    }
} else {
    header("location: ../index.php");
}
?>