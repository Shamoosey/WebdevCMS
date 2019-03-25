<?php
    session_start();
    $validUser = false;


    if(isset($_SESSION["USERID"])){
        $userID = $_SESSION["USERID"];
        require "actions/connect.php";

        $query = $db -> prepare("SELECT * FROM users WHERE UserID = '$userID'");
        $query -> execute();
        $user = $query -> fetchAll();

        
        if(isset($user[0])){
            //print_r($user[0]);
            $validUser = true;
        }
    } else {
        header("location: index.php");
    }
    session_abort();
?>

<!DOCTYPE html>
<html>
<?php require "head.php"; ?>
<body>
    <?php require "header.php" ?>


    <?php require "footer.php" ?>
</body>
</html>