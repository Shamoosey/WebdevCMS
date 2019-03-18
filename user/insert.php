<?php
    $errorFlag = false;
    $fields = ['username', 'fname', 'lname', 'password', 'email'];
    $userFields = array();

    foreach ($fields as $value) {
        if($_POST["$value"]){
            array_push($userFields, filter_input(INPUT_POST,"$value",FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        } else {
            $errorFlag = true;
        }
    }

    require("../actions/connect.php");
    $insert = "INSERT INTO users (UserID, Username, FirstName, LastName, Password, Email) VALUES (NULL, :username, :fname, :lname, :password, :email)";
    $put = $db -> prepare($insert);
    $put -> bindValue(':username', $userFields[0]);
    $put -> bindValue(':fname', $userFields[1]);
    $put -> bindValue(':lname', $userFields[2]);
    $put -> bindValue(':password', $userFields[3]);
    $put -> bindValue(':email', $userFields[4]);
    $put -> execute();
    $db -> lastInsertId();
?>
<!DOCTYPE html>
<html>
<?php require "../head.php"?>
<body>
    <?php require "../header.php";

    foreach ($userFields as $value) {
        echo("$value" . " ");
    }
    ?>
    <?php require "../footer.php" ?>
</body>
</html>