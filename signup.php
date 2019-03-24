<?php
    $errorFlag = false;

    //array of all the posted values
    $fields = ['username', 'fname', 'lname', 'password', 'email'];
    $userFields = array();

    foreach ($fields as $value) {
        //Checking if the post is set
        if(isset($_POST[$value])){
            //checking if the post has anything in it
            if($_POST[$value] != ""){
                //pushing the value to the array
                array_push($userFields, filter_input(INPUT_POST, $value ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));

                /*
                *
                * ADD MORE BACKEND VALIDATION HERE AT LATER TIME
                *
                */

            } else {
                header("Location: error.php");
                $errorFlag = true;
            }
        } else {
            $errorFlag = true;
        }
    }
    if(!$errorFlag){
        require("actions/connect.php");
        $insert = "INSERT INTO users (UserID, Username, FirstName, LastName, Password, Email) VALUES (NULL, :username, :fname, :lname, :password, :email)";

        $put = $db -> prepare($insert);
        $username = strtoupper($userFields[0]);
        $put -> bindValue(':username', $username);
        $put -> bindValue(':fname', $userFields[1]);
        $put -> bindValue(':lname', $userFields[2]);

        $hashedPass = password_hash($userFields[3], PASSWORD_DEFAULT);
        $put -> bindValue(':password', $hashedPass);
        $put -> bindValue(':email', $userFields[4]);
        $put -> execute();
    
        $query = $db -> prepare("SELECT * FROM users WHERE UserName = '$userFields[0]'");
        $query -> execute();
        $user = $query -> fetchAll();

        session_start();
        $_SESSION["USERID"] = $user[0]["UserID"];

        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php require "head.php" ?>
    <body>
        <?php require "header.php" ?>
        <?php if(!isset($_SESSION["USERID"])): ?>
            <script src="assets/js/signupValidate.js"></script>
            <form class="uk-align-center" id="signup" action="signup.php" method="post">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">Personal Information</legend>
                <div class="uk-margin-small">
                    First Name: <input class="uk-input uk-form-width-medium" id="fname" name="fname" type="text" placeholder="First Name"/>
                    <span class="personalError error" id="fname_error">* Required field</span><br/>
                </div>
                <div class="uk-margin-small">
                    Last Name: <input class="uk-input uk-form-width-medium" id="lname" name="lname" type="text" placeholder="Last Name"/>
                    <span class="personalError error" id="lname_error">* Required field</span><br/>
                </div>
                <div class="uk-margin-small">
                    Email: <input class="uk-input uk-form-width-medium" id="email" name="email" type="text" placeholder="Email Address" />
                    <span class="personalError error" id="email_error">* Required field</span>
                    <span class="personalError error" id="emailformat_error">* Invalid email address</span><br/>
                </div>
                </fieldset>

                <div class="uk-margin-top">
                    <fieldset class="uk-fieldset">
                </div>

                <legend class="uk-legend">User Information</legend>
                <div class="uk-margin-small">
                    UserName: <input class="uk-input uk-form-width-medium" id="username" name="username" type="text" placeholder="Username" />
                    <span class="userError error" id="username_error">* Required field</span>
                    <span class="userError error" id="usernameTaken_error">* Username taken</span><br/>
                </div>
                <div class="uk-margin-small">
                    Password: <input class="uk-input uk-form-width-medium" class="password" id="password" name="password" type="password" placeholder="Password" />
                    <span class="userError error" id="password_error">* Required field</span>
                    <span class="userError error" id="passwordLength_error">* Password must be more then 5 characters</span><br/>
                </div>
                <div class="uk-margin-small">
                    Re-type Password: <input class="uk-input uk-form-width-medium" id="validatePassword" type="password" placeholder="Confirm Password" />
                    <span class="userError error" id="passwordMatch_error">* Passwords do not match</span><br/>
                </div>
                </fieldset>
                <button class="uk-button-primary uk-button-small" type="submit" id="submit">Sign Up</button>
                <button class="uk-button-danger uk-button-small" type="reset" id="clear">Reset</button>
            </form>
            <a href="login.php">Already have an account? Login!</a>
        <?php else: ?>
            <p>Whoops! Looks like you are already signed in. <a href="actions/signout.php">Sign Out</a>
        <?php endif?>
        <?php require "footer.php" ?>
    </body>
</html>