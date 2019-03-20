<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <?php require "header.php" ?>
    <?php if(isset($_SESSION["USERID"])): ?>
    <?php else :?>
        <p>Whoops! Looks like you are not signed in. <a href="login.php">Login</a>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>