<?php
    session_start();
    $validuser = false;
    $loopcount = 0;
    $error = false;
    $nouser = false;
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validuser = true;
        }
    }

    $CurrentUserID = $_SESSION["USERID"];

    if($validuser){

        //for ordering the users
        $orderby = "Username";
        if(isset($_GET['orderby'])){
            if(strtolower($_GET['orderby']) == 'username'){
                $orderby = "Username ASC";
            } elseif(strtolower($_GET['orderby']) == 'userid') {
                $orderby = "UserID ASC";
            } else {
                $orderby = "UserID ASC";
            }
        }

        require "actions/connect.php";

        //Display all users that are not self
        $query = $db -> prepare("SELECT * FROM users WHERE UserID != '$CurrentUserID' ORDER BY {$orderby}");
        $query -> bindValue(':orderby', trim($orderby));
        $query -> execute();
        $user = $query -> fetchAll();


    } else {
        header("location: index.php");
    }
    if(isset($_GET["error"])){
        if($_GET["error"] == true){
            $error = true;
        }
    } elseif(isset($_GET["nouser"])){
        if($_GET["nouser"] == true){
            $nouser = true;
        }
    }
    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <?php require "header.php" ?>
    <?php if($validuser): ?>
        <h2 class="uk-text-center">Admin Control Pannel</h2>
        <form action="selectuseradmin.php" method="post">
            <div class="uk-flex uk-flex-center">
                <input class="uk-input uk-form-width-medium" type="text" name="username" id="text" placeholder="Search for a user"/>
                <button class="uk-button uk-button-primary uk-margin-left" type="submit">Search</button>
            </div>
        </form>
        <h3 class="uk-text-center uk-margin-bottom"><a href="signup.php?admin=1">Create User</a></h3>
        <?php if($error) : ?>
            <div class="uk-text-center uk-text-danger">
                <span>An error has occurred, please try again</span>
            </div>
        <?php elseif($nouser) : ?>
            <div class="uk-text-center uk-text-danger">
                <span>User not found, please try again</span>
            </div>
        <?php endif ?>
        <table class="uk-table uk-margin-auto uk-table-divider">
            <thead>
                <tr>
                    <th><a href="admin.php?orderby=userid">UserID</a></th>
                    <th><a href="admin.php?orderby=username">Username</a></th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($user as $user): 
                        $fullname = ($user["FirstName"] . " " . $user["LastName"]);
                        $loopcount += 1; 
                        $username =ucfirst(strtolower($user["Username"]));
                        ?>
                    <tr>
                        <td><?= $user["UserID"] ?></td>
                        <td><?= $username ?></td>
                        <td><?= $user["Email"] ?></td>
                        <td><?= $fullname ?></td>
                        <td><a href="selectuseradmin.php?userid=<?= $user["UserID"]?>">Select User</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</body>
</html>