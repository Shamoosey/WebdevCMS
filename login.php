<?php
    $errorFlag = false;
    $fields = ['username', 'password'];
    $login = array();
    if(!isset($_SESSION["USERID"])){
        foreach($fields as $value){
            if(isset($_POST[$value])){
                if($_POST[$value] != ""){
                    array_push($login, filter_input(INPUT_POST, $value ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                } else {
                    $errorFlag = true;
                }
            } else {
                $errorFlag = true;
            }
        }
    } else {
        $errorFlag = true;
    }

    if(!$errorFlag){
        $query = $db -> prepare("SELECT `UserID`, `Password` FROM users WHERE UserName = '$login[0]'");
        $query -> execute();
        $userID = $query -> fetchAll();

        if($userID[1] == trim($login[1])){
            session_start();
            $_SESSION["USERID"] = $userID[0];
        }
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <?php require "header.php" ?>
    <?php if(!isset($_SESSION["USERID"])): ?>
        <form action="login.php" method="post">
            <fieldset>
                <legend>Login</legend>
                UserName: <input id="username" name="username" type="text" placeholder="Username" /><br/>

                Password: <input class="password" id="password" name="password" type="password" placeholder="Password" />

            </fieldset>
            <button type="submit" id="submit">Login</button>
            <a href="#">Forgot password</a>
        </form>
        <a href="signup.php">Don't have an account? Sign up!</a>
    <?php else :?>
        <p>Whoops! Looks like you are already signed in. <a href="actions/signout.php">Sign Out</a>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>