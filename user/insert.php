<?php
    $errorFlag = false;
    $fields = ['fname', 'lname', 'email', 'username'];
    $userFields = array();

    foreach ($fields as $value) {
        if($_POST["$value"]){
            array_push($userFields, filter_input(INPUT_POST,"$value",FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        } else {
            $errorFlag = true;
        }
    }
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