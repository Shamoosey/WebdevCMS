<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <div class="uk-background-cover uk-background-fixed uk-background-center-center uk-height-viewport" style="background-image: url(assets/images/index-background.jpg);">  
        <?php require "header.php" ?>
        <div style="opacity: 0.9;" class="uk-width-1-2 uk-align-center uk-card uk-card-body uk-text-center uk-card-default">
            <h1 class="uk-text-center"><span>Explore Manitoba</span></h1>
            <div class="uk-flex uk-flex-center">
                <input class="uk-input uk-form-width-large" type="text" id="text" placeholder="Search for a keyword"/>
                <button class="uk-button uk-button-secondary uk-margin-left">Search</button>
            </div>
        </div>
    </div>
    <?php require "footer.php" ?>
</body>
</div>
</html>