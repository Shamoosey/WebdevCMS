<?php 
    $likeclause = "%";
    $orderby = "PostDate";
    $order = "DESC";
    $userID = 0;
    $admin = false;
    session_start();

    if(isset($_POST["search"])){
        $likeclause = strtolower(trim(filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
    }

    if(isset($_SESSION["USERID"])){
        $userID = $_SESSION["USERID"];
    }

    if(isset($_SESSION["ADMIN"])){
        $admin = $_SESSION["ADMIN"] == 1? true : false ;
    }

    if(isset($_POST["filter"]) && isset($_POST["order"])){
        if($_POST["filter"] == "postdate"){
            $orderby = "PostDate";
        } elseif($_POST["filter"] == "username"){
            $orderby = "UserID";
        }

        if($_POST["order"] == "asc"){
            $order = "ASC";
        } else {
            $order = "DESC";
        }
    }

    require "actions/connect.php";
    $query = $db -> prepare("SELECT * FROM posts WHERE LOWER(PostTitle) LIKE '%{$likeclause}%' ORDER BY {$orderby} {$order}");
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
            <form action="allposts.php" method="post"> 
                <div class="uk-margin uk-flex">
                    <span>Filter Posts: </span>
                    <select class="uk-select uk-form-width-medium uk-margin-left" name="filter">
                        <option value="postdate">Date Posted</option>
                        <option value="username">Username</option>
                    </select>
                    <div class="uk-flex uk-flex-column uk-margin-left">
                        <label><input class="uk-radio" type="radio" name="order" value="asc"> Ascending</label>
                        <label><input class="uk-radio" type="radio" name="order" checked value="desc"> Descending</label>
                    </div>
                    <button class="uk-button-primary uk-button-small uk-margin-left" type="submit" id="submit">Filter</button>
                </div>
            </form>
            <?php foreach ($posts as $post) : 
                $postDate = substr($post['PostDate'], 0, 10);
                $postTime = date('h:i a', strtotime(substr($post['PostDate'], 11, 8)));

                $user = $post["UserID"];
                $query = $db -> prepare("SELECT Username FROM users WHERE UserID = '$user'");
                $query -> execute();
                $user = $query -> fetch();    
            ?>
                <div class="uk-card uk-card-default uk-card-body uk-margin">
                    <a href="viewpost.php?postid=<?= $post['PostID'] ?>"><h3 class="uk-card-title uk-margin-remove-bottom"><?= $post["PostTitle"]?></h3></a>
                    <span><?= $postDate?> at <?= $postTime ?></span>
                    <span>Posted by <?= ucfirst(strtolower($user["Username"])) ?> </span>
                    <?php if($userID == $post['UserID'] || $admin) : ?>
                        <a href="editpost.php?postid=<?=$post['PostID']?>">Edit Post</a>
                    <?php endif ?>
                    <p style="word-wrap: break-word;">
                        <?= $post["PostContent"]?>
                    </p>
                    <?php if($post["PostImage"] != null) : ?>
                    <a href="<?= $post["PostImage"]?>"><img src="<?= $post["PostImage"]?>" height="200" width="300"/></a>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
    <!--</div>-->
    <?php require "footer.php" ?>
</body>
</html>