<?php
    session_start();
    $validuser = false;
    $loopcount = 0;
    if(isset($_SESSION["USERID"])){
        if($_SESSION["ADMIN"] == 1){
            $validuser = true;
        }
    }

    if($validuser){

        require "actions/connect.php";

        $query = $db -> prepare("SELECT * FROM users");
        $query -> execute();
        $user = $query -> fetchAll();


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
    <?php if($validuser): ?>
        <h2 class="uk-text-center uk-margin-bottom"><span>Admin Control Pannel</span></h2>
        <div class="uk-flex uk-flex-between uk-flex-column">
            <?php 
                foreach($user as $user): 
                $fullname = ($user["FirstName"] . " " . $user["LastName"]);
                $loopcount += 1; 
            ?>
                <form action="admin.php" method="post">
                    <div class ="uk-flex uk-flex-around">
                        <span class="uk-margin-right"><?= $user["UserID"] ?></span>
                        <span class="uk-margin-right"><?= $user["Username"] ?></span>
                        <span class="uk-margin-right"><?= $user["Email"] ?></span>
                        <span class="uk-margin-right"><?= $fullname ?></span>
                        <input type="hidden" name="UserID" value="<?= $user["UserID"] ?>"/>

                        <button class="uk-button uk-button-primary uk-margin-bottom" type="submit">Select User</button>
                    </div>
                </form>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</body>
</html>