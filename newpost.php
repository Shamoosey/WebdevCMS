<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <?php require "header.php" ?>
    <?php if(isset($_SESSION["USERID"])): ?>
        <h1 class="uk-text-center"><span>New Post</span></h1>
        <form action="newpost.php" method="post" class="uk-align-center">
            <div class="uk-flex uk-flex-center">
                <fieldset class="uk-fieldset">

                    <div uk-form-custom="target: true">
                        <input type="file">
                        Image: <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
            
                    <div class="uk-margin-small">
                        Text: <textarea class="uk-textarea" id="content" name="content" type="textarea" placeholder="Content"></textarea>
                    </div>
                </fieldset>
            </div>
            <div class="uk-flex uk-flex-center"> 
                <button class="uk-button-primary uk-button-small uk-margin-right" type="submit" id="submit">Login</button>
            </div>
        </form>
    <?php else :?>
        <p>You need to be <a href="login.php">signed in</a> to make a post.</p>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>