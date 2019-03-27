<?php
    $validUser = false;
    $error = false;

    session_start();

    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validUser = true;
        }
    }
    //ensuring that the user is valid and supposed to be here
    if($validUser){

        require "actions/connect.php";
        
        $userID = filter_input(INPUT_GET, "userid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $query = $db -> prepare("SELECT * FROM users WHERE UserID = '$userID'");
        $query -> execute();
        $user = $query -> fetch();
        $username =ucfirst(strtolower($user["Username"]));
    } else {
        //if the user is not valid send them back to main
        header("location: admin.php");
    }    
    session_abort();
?>
<!DOCTYPE html>
<html>
    <?php require "head.php" ?>
<body>
    <?php require "header.php" ?>

    <script src="assets\js\changepasswordValidate.js"></script>
    <h2 class="uk-text-center uk-margin-bottom">Change Password for <?= $username ?></h2>
    <?php if($error) : ?>
            <div class="uk-text-center uk-text-danger">
                An error has occurred, please try again
            </div>
        <?php endif ?>
    <div class="uk-flex uk-flex-center">
        <form action="actions/changepassword.php" method="post">
                <input type="hidden" name="userid" value="<?=$user["UserID"] ?>" />

                <div class="uk-margin-small">
                    Password: <input class="uk-input uk-form-width-medium" id="password" name="password" type="password" placeholder="Password" /><br/>
                    <span class="userError error" id="password_error">* Required field</span>
                    <span class="userError error" id="passwordLength_error">* Password must be more then 5 characters</span>
                </div>

                <div class="uk-margin-small">
                    Confirm: <input class="uk-input uk-form-width-medium" id="validatePassword" name="password" type="password" placeholder="Confirm Password"/><br/>
                    <span class="userError error" id="passwordMatch_error">* Passwords do not match</span>
                </div>


            <div class="uk-margin-small">
                <button class="uk-button uk-button-primary" id="submit" type="submit">Change Password</button>
            </div>
            <div class="uk-margin-small">
                <button class="uk-button uk-button-default" formaction="selectuseradmin.php?userid=<?=$user["UserID"]?>">Back</button>
            </div>  

        </form>
    </div>
    <?php require "footer.php"?>
</body>
</html>