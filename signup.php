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
            }
        } else {
            $errorFlag = true;
        }
    }
    //if the errorFlag is true then redirect the user to the error page.
    if(!$errorFlag){
        //Putting the items into the DB
        require("actions/connect.php");
        $insert = "INSERT INTO users (UserID, Username, FirstName, LastName, Password, Email) VALUES (NULL, :username, :fname, :lname, :password, :email)";
        $put = $db -> prepare($insert);
        $put -> bindValue(':username', $userFields[0]);
        $put -> bindValue(':fname', $userFields[1]);
        $put -> bindValue(':lname', $userFields[2]);
        $put -> bindValue(':password', $userFields[3]);
        $put -> bindValue(':email', $userFields[4]);
        $put -> execute();
    
        $query = $db -> prepare("SELECT UserID FROM users WHERE UserName = '$userFields[0]'");
        $queryBlog -> execute();
        $userID = $queryBlog -> fetchAll();

        $_SESSION['userID'] = $userID;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php require "head.php" ?>
    <body>
        <?php require "header.php" ?>
        <script src="assets/js/signupValidate.js"></script>
        <form id="signup" action="index.php" method="post">
            <fieldset>
                <legend>Personal Information</legend>
                First Name: <input id="fname" name="fname" type="text" placeholder="First Name"/>
                <span class="addressError error" id="fname_error">* Required field</span><br/>

                Last Name: <input id="lname" name="lname" type="text" placeholder="Last Name"/>
                <span class="addressError error" id="lname_error">* Required field</span><br/>

                Email: <input id="email" name="email" type="text" placeholder="Email Address" />
                <span class="addressError error" id="email_error">* Required field</span>
                <span class="addressError error" id="emailformat_error">* Invalid email address</span><br/>
            </fieldset>
            <fieldset>
            <legend>User Information</legend>
                UserName: <input id="username" name="username" type="text" placeholder="Username" />
                <span class="userError error" id="username_error">* Required field</span>
                <span class="userError error" id="usernameTaken_error">* Username taken</span><br/>

                Password: <input class="password" id="password" name="password" type="password" placeholder="Password" />
                <span class="userError error" id="password_error">* Required field</span>
                <span class="userError error" id="passwordLength_error">* Password must be more then 5 characters</span><br/>

                Re-type Password: <input id="validatePassword" type="password" placeholder="Confirm Password" />
                <span class="userError error" id="passwordMatch_error">* Passwords do not match</span><br/>

            </fieldset>
            <button type="submit" id="submit">Sign Up</button>
            <button id="clear">Reset</button>
        </form>
        <?php require "footer.php" ?>
    </body>
</html>