<?php   
    $validUser = false;
    session_start();
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validUser = true;
        }
    }
    if($validUser){

        $userID = filter_input(INPUT_GET, "userid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        require "actions/connect.php";
    
        $query = $db -> prepare("SELECT * FROM users WHERE UserID = '$userID'");
        $query -> execute();
        $user = $query -> fetchAll();
        $username =ucfirst(strtolower($user[0]["Username"]));

    } else {
        header("location: index.php");
    }
    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <?php require "header.php" ?>
    <h2 class="uk-text-center uk-margin-bottom"><span>Edit User <?= $username ?></span></h2>
    <div class="uk-flex uk-flex-center">
        <form action="edituseradmin.php" method="post">
                <input type="hidden" name="userid" value="<?=$user[0]["UserID"] ?>" />
            <div class="uk-margin-small">
                Username: <input type="text" name="username" class="uk-input uk-form-width-medium" value="<?= $username ?>"/> <br/>
            </div>

            <div class="uk-margin-small">
                Email: <input type="text" name="email" class="uk-input uk-form-width-medium" value="<?= $user[0]["Email"] ?>" />
            </div>

            <div class="uk-margin-small">
                Fist Name: <input type="text" name="fname" class="uk-input uk-form-width-medium" value="<?= $user[0]["FirstName"] ?>" />
            </div>
            
            <div class="uk-margin-small">
            Last Name: <input type="text" name="lname" class="uk-input uk-form-width-medium" value="<?= $user[0]["LastName"] ?>" />
            </div>

            <div class="uk-margin-small">
                <button class="uk-button uk-button-primary" formaction="changepasswordadmin.php?userid=<?= $user[0]["UserID"] ?>">Change Password</button>
                <button class="uk-button uk-button-primary" type="submit">Edit</button>
                <button class="uk-button uk-button-danger" formaction="deleteuser.php?userid=<?= $user[0]["UserID"] ?>">Delete</button>
            </div>
            <div class="uk-margin-small">
                <button class="uk-button uk-button-default" formaction="admin.php">Back</button>
            </div>  
        </form>
    </div>
    <?php require "footer.php" ?>
</body>
</html>