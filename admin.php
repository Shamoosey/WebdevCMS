<?php
    session_start();
    $validuser = false;
    $loopcount = 0;
    $userediterror = false;
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validuser = true;
        }
    }

    $CurrentUserID = $_SESSION["USERID"];

    if($validuser){

        require "actions/connect.php";

        //Display all users that are not self
        $query = $db -> prepare("SELECT * FROM users WHERE UserID != '$CurrentUserID'");
        $query -> execute();
        $user = $query -> fetchAll();


    } else {
        header("location: index.php");
    }
    if(isset($_GET["error"])){
        if($_GET["error"] == true){
            $userediterror = true;
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
        <h2 class="uk-text-center uk-margin-bottom">Admin Control Pannel</h2>
        <?php if($userediterror) : ?>
            <div class="uk-text-center uk-text-danger">
                An error has occurred, please try again
            </div>
        <?php endif ?>
        <table class="uk-table uk-margin-left">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Username</th>
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
                        <td><a class="uk-margin-right" href="selectuseradmin.php?userid=<?= $user["UserID"]?>">Select User</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</body>
</html>