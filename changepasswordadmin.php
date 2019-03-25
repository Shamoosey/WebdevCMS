<?php
    $validUser = false;
    session_start();
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validUser = true;
        }
    }
    if($validUser){

    } else {
        header("location: index.php");
    }
    session_abort();
?>
<!DOCTYPE html>
<html>
    <?php require "head.php" ?>
<body>
    <?php require "header.php" ?>


    <?php require "footer.php"?>
</body>
</html>