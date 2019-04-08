<?php 
    $invalidPost = false;
    $userID = 0;
    session_start();
    if(isset($_SESSION["USERID"])){
        $userID = $_SESSION["USERID"];
    }

    if(isset($_SESSION["ADMIN"])){
        $admin = $_SESSION["ADMIN"] == 1? true : false ;
    }

    if(isset($_GET['postid'])){
        $postid = filter_input(INPUT_GET, "postid", FILTER_SANITIZE_NUMBER_INT);
        require "actions/connect.php";
        $query = $db -> prepare("SELECT * FROM posts WHERE PostID = '$postid'");
        $query -> execute();
        $post = $query -> fetch();
        $rows = $query -> rowcount();

        $user = $post["UserID"];
        $query = $db -> prepare("SELECT Username FROM users WHERE UserID = '$user'");
        $query -> execute();
        $user = $query -> fetch();  

        if($rows == 0){
            $invalidPost = true;
        }
    } else {
        $invalidPost = true;
    }
    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <?php require "header.php" ?>
    <?php if($invalidPost) : ?>
    <div class="uk-card uk-card-default uk-card-body uk-margin uk-width-1-2 uk-align-center uk-child-width-1-1@m">
        <p>Sorry, invalid post. Back to <a href="allposts.php">all posts</a>.</p>
    </div>

    <?php else : 
        $postDate = substr($post['PostDate'], 0, 10);
        $postTime = date('h:i a', strtotime(substr($post['PostDate'], 11, 8)));
    ?>
        <div class="uk-card uk-card-default uk-card-body uk-margin uk-width-1-2 uk-align-center uk-child-width-1-1@m">
            <a href="viewpost.php?postid=<?= $post['PostID'] ?>"><h3 class="uk-card-title uk-margin-remove-bottom"><?= $post["PostTitle"]?></h3></a>
            <span><?= $postDate?> at <?= $postTime ?></span>
            <span>Posted by <?= ucfirst(strtolower($user["Username"])) ?> </span>
            <?php if($userID == $post['UserID']) : ?>
                <a href="editpost.php?postid=<?=$post['PostID']?>">Edit Post</a>
            <?php endif ?>
            <p style="word-wrap: break-word;">
                <?= $post["PostContent"]?>
            </p>
            <?php if($post["PostImage"] != null) : ?>
            <a href="<?= $post["PostImage"]?>"><img src="<?= $post["PostImage"]?>" height="200" width="300"/></a>
            <?php endif ?>
        </div>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>