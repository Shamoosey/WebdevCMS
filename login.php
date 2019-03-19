<?php
    $invalidlogin = false;
    //check if user is logged in
    if(!isset($_SESSION["USERID"])){

        //check if posted values are set
        if(isset($_POST["username"]) && isset($_POST["password"])){

            //check if posted values contain anything
            if(!empty($_POST["username"] && !empty($_POST["password"]))){

                require("actions/connect.php");
                $query = $db -> prepare("SELECT * FROM users WHERE UserName = :username");
    
                $username = strtoupper(filter_input(INPUT_POST, "username",FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $password = filter_input(INPUT_POST, "password" ,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                $query -> bindValue(':username', $username);
                $query -> execute();
                $user = $query -> fetchAll();
                $rowCount = $query -> rowCount();
                if ($rowCount == 1){
                    if(password_verify($password, $user[0]["Password"])){
                        session_start();
                        $_SESSION["USERID"] = $user[0]["UserID"];
                        header("location: index.php");
                    }
                } else {
                    $invalidlogin = true;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <?php require "header.php" ?>
    <?php if(!isset($_SESSION["USERID"])): ?>
        <script src="assets/js/loginValidate.js"></script>
        <form action="login.php" method="post">
            <fieldset>
                <legend>Login</legend>
                UserName: <input id="username" name="username" type="text" placeholder="Username" />
                <span class="userError error" id="username_error">* Required field</span><br/>

                Password: <input class="password" id="password" name="password" type="password" placeholder="Password" />
                <span class="userError error" id="password_error">* Required field</span><br/>
            </fieldset>
            <button type="submit" id="submit">Login</button>
            <?php if($invalidlogin): ?>
                <span style="color: #F00;"> Invalid Login, please try again.</span><br/>
            <?php endif ?>
            <a href="#">Forgot password</a>
        </form>
        <a href="signup.php">Don't have an account? Sign up!</a>
    <?php else :?>
        <p>Whoops! Looks like you are already signed in. <a href="actions/signout.php">Sign Out</a>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>