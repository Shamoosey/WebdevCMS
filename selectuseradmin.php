<?php   
    $validUser = false;
    session_start();
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validUser = true;
        }
    }
    if($validUser && ISSET($_GET['userid'])){

        $userID = filter_input(INPUT_GET, "userid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        require "actions/connect.php";
    
        $query = $db -> prepare("SELECT * FROM users WHERE UserID = '$userID'");
        $query -> execute();
        $user = $query -> fetch();
        $username =ucfirst(strtolower($user["Username"]));

    } elseif ($validUser && isset($_POST['username'])) {
        if(trim($_POST['username']) != ""){
            $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            require "actions/connect.php";
    
            $query = $db -> prepare("SELECT * FROM users WHERE Username = '$username'");
            $query -> execute();
            $queryCount = $query -> rowCount();
            $user = $query -> fetch();
        } else {
            header("location: admin.php?nouser=true");
        }
    } else {
        header("location: admin.php?error=true");
    }
    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <?php require "header.php" ?>
    <?php if($queryCount == 1) : ?>
        <h2 class="uk-text-center uk-margin-bottom">Edit User <?= $username ?></h2>
        <div class="uk-flex uk-flex-center">
            <form action="edituseradmin.php" method="post">
                    <input type="hidden" name="userid" value="<?=$user["UserID"] ?>" />
                <div class="uk-margin-small">
                    Username: <input type="text" name="username" class="uk-input uk-form-width-medium" value="<?= $username ?>"/> <br/>
                </div>

                <div class="uk-margin-small">
                    Email: <input type="text" name="email" class="uk-input uk-form-width-medium" value="<?= $user["Email"] ?>" />
                </div>

                <div class="uk-margin-small">
                    Fist Name: <input type="text" name="fname" class="uk-input uk-form-width-medium" value="<?= $user["FirstName"] ?>" />
                </div>
                
                <div class="uk-margin-small">
                Last Name: <input type="text" name="lname" class="uk-input uk-form-width-medium" value="<?= $user["LastName"] ?>" />
                </div>

                <div class="uk-margin-small">
                    <button class="uk-button uk-button-primary" formaction="changepasswordadmin.php?userid=<?= $user["UserID"] ?>">Change Password</button>
                    <button class="uk-button uk-button-primary" type="submit">Confirm Edit</button>
                </div>
                <div class="uk-margin-small">
                    <button class="uk-button uk-button-default" formaction="admin.php">Back</button>
                    <button class="uk-button uk-button-danger" formaction="deleteuser.php?userid=<?= $user["UserID"] ?>">Delete</button>
                </div>  
            </form>
        </div>
    <?php else: ?>
        <?php header("location: admin.php?nouser=true") ?>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>