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
                        $_SESSION["ADMIN"] = $user[0]["Admin"];
                        header("location: index.php");
                        $invalidlogin = false;
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
        <h1 class="uk-text-center"><span>Login</span></h1>
        <form action="login.php" method="post" class="uk-align-center">
            <div class="uk-flex uk-flex-center">
                <fieldset class="uk-fieldset">
                    <div class="uk-margin-small">
                        UserName: <input class="uk-input uk-form-width-medium" id="username" name="username" type="text" placeholder="Username" /><br/>
                        <span class="userError error" id="username_error">* Required field</span>
                    </div>
            
                    <div class="uk-margin-small">
                        Password: <input class="uk-input uk-form-width-medium" id="password" name="password" type="password" placeholder="Password" /><br/>
                        <span class="userError error" id="password_error">* Required field</span>
                    </div>
                </fieldset>
            </div>
            <div class="uk-flex uk-flex-center"> 
                <button class="uk-button-primary uk-button-small uk-margin-right" type="submit" id="submit">Login</button>
                <a href="#">Forgot password</a>
            </div>
            <div class="uk-flex uk-flex-center"> 
                <?php if($invalidlogin): ?>
                <span style="color: #F00;"> Invalid Login, please try again.</span><br/>
                <?php endif ?>
            </div>
        </form>
        <div class="uk-flex uk-flex-center">
            <a href="signup.php">Don't have an account? Sign up!</a>
        </div>
    <?php else :?>
        <p>Whoops! Looks like you are already signed in. <a href="actions/signout.php">Sign Out</a>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>