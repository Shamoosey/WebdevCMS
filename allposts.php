<?php 
    $likeclause = "%";
    $userID;
    $admin = false;
    session_start();
    if(isset($_POST["search"])){
        $likeclause = trim(filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }

    if(isset($_SESSION["USERID"])){
        $userID = $_SESSION["USERID"];
    }

    if(isset($_SESSION["ADMIN"])){
        $admin = $_SESSION["ADMIN"] == 1? true : false ;
    }
    
    require "actions/connect.php";
    $query = $db -> prepare("SELECT * FROM posts WHERE PostTitle LIKE '%{$likeclause}%' ORDER BY PostDate DESC");
    $query -> execute();
    $posts = $query -> fetchAll();
    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <!--<div class="uk-background-cover uk-background-fixed uk-background-center-center uk-height-viewport" style="background-image: url(assets/images/index-background.jpg);">-->
        <?php require "header.php" ?>
        <div class="uk-width-1-2 uk-align-center uk-child-width-1-1@m" uk-grid>
            <?php foreach ($posts as $post) : 
                $postDate = substr($post['PostDate'], 0, 10);
                $postTime = date('h:i a', strtotime(substr($post['PostDate'], 11, 8)));    
            ?>
                <div class="uk-card uk-card-default uk-card-body uk-margin">
                    <h3 class="uk-card-title uk-margin-remove-bottom"><?= $post["PostTitle"]?></h3>
                    <span><?= $postDate?> at <?= $postTime ?></span>
                    <p style="word-wrap: break-word;">
                        <?= $post["PostContent"]?>
                    </p>
                    <?php if($post["PostImage"] != null) : ?>
                    <a href="<?= $post["PostImage"]?>"><img src="<?= $post["PostImage"]?>" style="width:300px;height:300px;"/></a>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
    <!--</div>-->
    <?php require "footer.php" ?>
</body>
</html>