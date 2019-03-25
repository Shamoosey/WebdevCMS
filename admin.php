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
        <table class="uk-table uk-margin-auto">
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
                        <td><a class="" href="selectuseradmin.php?userid=<?= $user["UserID"]?>">Select User</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</body>
</html>