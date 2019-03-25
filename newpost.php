<?php
    

?>
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
                    <div class="uk-margin-small">
                        Title: <input class="uk-input" id="title" name="title" type="text" placeholder="Title" />
                    </div>

                    <div class="uk-margin-small">
                        Text: <textarea class="uk-textarea" id="content" name="content" type="textarea" placeholder="Content"></textarea>
                    </div>
                    <div class="uk-margin-small" uk-form-custom="target: true">
                        <input type="file">
                        Image: <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
            
                </div>
            </fieldset>

            <div class="uk-flex uk-flex-center uk-margin-top"> 
                <button class="uk-button-primary uk-button-small uk-margin-right" type="submit" id="submit">Login</button>
            </div>
        </form>
    <?php else :?>
        <p>You need to be <a href="login.php">signed in</a> to make a post.</p>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>