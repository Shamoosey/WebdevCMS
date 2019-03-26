<?php
    $errorFlag = false;
    $adminControl = false;
    $usernameTaken = false;
    $noSubmissionError = false;

    //array of all the posted values
    $fields = ['username', 'fname', 'lname', 'password', 'email'];
    $userFields = array();
    session_start();

    if(isset($_SESSION["ADMIN"])){
        if($_SESSION["ADMIN"] == 1){
            $adminControl = true;
        }
    }


    foreach ($fields as $value) {
        //Checking if the post is set
        if(isset($_POST[$value])){
            //checking if the post has anything in it
            if($_POST[$value] != ""){
                //pushing the value to the array
                array_push($userFields, filter_input(INPUT_POST, $value ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            } else {
                $errorFlag = true;
                $noSubmissionError = true;
            }
        } else {
            $errorFlag = true;
        }
    }
    
    //checking if the username is taken
    if(isset($_POST["username"])){
        require("actions/connect.php");
        $query = $db -> prepare("SELECT * FROM users");
        $query -> execute();
        $user = $query -> fetchAll();
        

        foreach ($user as $user) {
            if(strtoupper(trim($_POST["username"])) == $user["Username"]){
                $errorFlag = true;
                $usernameTaken = true;
            }
        }
    }

    if(!$errorFlag){
        
        //insert the values into the db as a new user
        $insert = "INSERT INTO users (UserID, Username, FirstName, LastName, Password, Email) VALUES (NULL, :username, :fname, :lname, :password, :email)";

        $put = $db -> prepare($insert);
        $username = strtoupper($userFields[0]);
        $put -> bindValue(':username', trim($username));
        $put -> bindValue(':fname', $userFields[1]);
        $put -> bindValue(':lname', $userFields[2]);

        $hashedPass = password_hash($userFields[3], PASSWORD_DEFAULT);
        $put -> bindValue(':password', $hashedPass);
        $put -> bindValue(':email', $userFields[4]);
        $put -> execute();
    
        $userQuery = $db -> prepare("SELECT UserID, Admin FROM users WHERE UserName = '$userFields[0]'");
        $userQuery -> execute();
        $user = $userQuery -> fetchAll();

        $_SESSION["USERID"] = $user[0]["UserID"];
        $_SESSION["ADMIN"] = $user[0]["Admin"];

        if($adminControl){
            header("location: admin.php");
        } else {
            header("location: index.php");
        }
    } else {
        session_abort();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php require "head.php" ?>
    <body>
        <?php require "header.php" ?>
        <?php if(!isset($_SESSION["USERID"]) || $adminControl): ?>
            <script src="assets/js/signupValidate.js"></script>

            <?php if($adminControl): ?> 
                <h1 class="uk-text-center">Create User</h1>
            <?php else : ?>
                <h1 class="uk-text-center">Sign Up</h1>
            <?php endif ?>

            <form class="uk-align-center" id="signup" action="signup.php" method="post">
                <div class="uk-flex uk-flex-middle uk-flex-column"> 
                    <fieldset class="uk-fieldset">
                        <legend class="uk-legend">Personal Information</legend>
                        <div class="uk-margin-small">
                            First Name: <input class="uk-input uk-form-width-medium" id="fname" name="fname" type="text" placeholder="First Name"/><br/>
                            <span class="personalError error" id="fname_error">* Required field</span>
                        </div>
                        <div class="uk-margin-small">
                            Last Name: <input class="uk-input uk-form-width-medium" id="lname" name="lname" type="text" placeholder="Last Name"/><br/>
                            <span class="personalError error" id="lname_error">* Required field</span>
                        </div>
                        <div class="uk-margin-small">
                            Email: <input class="uk-input uk-form-width-medium" id="email" name="email" type="text" placeholder="Email Address" /><br/>
                            <span class="personalError error" id="email_error">* Required field</span>
                            <span class="personalError error" id="emailformat_error">* Invalid email address</span>
                        </div>
                    </fieldset>
                    <fieldset class="uk-fieldset">
                        <legend class="uk-legend">User Information</legend>
                        <div class="uk-margin-small">
                            UserName: <input class="uk-input uk-form-width-medium" id="username" name="username" type="text" placeholder="Username" /><br/>
                            <span class="userError error" id="username_error">* Required field</span>
                        </div>
                        <div class="uk-margin-small">
                            Password: <input class="uk-input uk-form-width-medium" id="password" name="password" type="password" placeholder="Password" /><br/>
                            <span class="userError error" id="password_error">* Required field</span>
                            <span class="userError error" id="passwordLength_error">* Password must be more then 5 characters</span>
                        </div>
                        <div class="uk-margin-small">
                            Confirm: <input class="uk-input uk-form-width-medium" id="validatePassword" name="password" type="password" placeholder="Confirm Password"/><br/>
                            <span class="userError error" id="passwordMatch_error">* Passwords do not match</span>
                        </div>
                    </fieldset>
                </div>
                <?php if($noSubmissionError) :?>
                    <div class="uk-text-center uk-text-danger">
                        An error has occurred, please try again.
                    </div>
                <?php elseif($usernameTaken) : ?>
                    <div class="uk-text-center uk-text-danger">
                        Username taken, please try again.
                    </div>
                <?php endif ?>
                <div class="uk-flex uk-flex-center">
                    <?php if($adminControl): ?>
                    <button class="uk-button-primary uk-button-small uk-margin-right" type="submit" id="submit">Create User</button>
                    <?php else : ?>
                        <button class="uk-button-primary uk-button-small uk-margin-right" type="submit" id="submit">Sign Up</button>
                    <?php endif ?>
                    <button class="uk-button-danger uk-button-small" type="reset" id="clear">Reset</button>
                </div>
            </form>
            <?php if(!$adminControl): ?>
                <div class="uk-flex uk-flex-center"> 
                    <a href="login.php">Already have an account? Login!</a>
                </div>
            <?php endif ?>
        <?php else: ?>
            <p>Whoops! Looks like you are already signed in. <a href="actions/signout.php">Sign Out</a>
        <?php endif?>
        <?php require "footer.php" ?>
    </body>
</html>