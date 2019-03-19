<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <?php require "header.php" ?>
        <form action="login.php" method="post">
            <fieldset>
                <legend>Login</legend>
                UserName: <input id="username" name="username" type="text" placeholder="Username" />
                <span class="userError error" id="username_error">* Required field</span><br/>

                Password: <input class="password" id="password" name="password" type="password" placeholder="Password" />
                <span class="userError error" id="password_error">* Required field</span>
            </fieldset>
            <button type="submit" id="submit">Login</button>
        </form>
        <a href="signup.php">Don't have an account? Sign up!</a>
    
    <?php require "footer.php" ?>
</body>
</html>