<?php 
    $valid = false;
    $admin = false;
    $errorFlag = false;
    $postid = 0;
    session_start();

    if(isset($_GET["postid"])){
        $postid = filter_input(INPUT_GET, "postid", FILTER_SANITIZE_NUMBER_INT);
    } else {
        $errorFlag = true;
    }

    if(isset($_SESSION["USERID"])){
        $userID = $_SESSION["USERID"];
    }

    if(isset($_SESSION["ADMIN"])){
        $admin = $_SESSION["ADMIN"] == 1 ? true : false ;
    }

    if(!$errorFlag){
        require "actions/connect.php";
        $query = $db -> prepare("SELECT * FROM posts WHERE PostID = '$postid'");
        $query -> execute();
        $post = $query -> fetch();
    }

    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <?php require "header.php" ?> 
        <?php if($admin || $valid || !$errorFlag) : ?>
            <h1 class="uk-text-center"><span>Edit Post</span></h1>
            <form action="edituserpost.php?postid=<?= $postid?>" method="post" class="uk-align-center">
                <div class="uk-flex uk-flex-center">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin-small">
                            Title: <input class="uk-input" id="title" name="title" type="text" value="<?= $post["PostTitle"] ?>"/>
                        </div>

                        <div class="uk-margin-small">
                            Text: <textarea class="uk-textarea" rows="5" id="content" name="content" type="textarea" ><?= $post["PostContent"] ?></textarea>
                        </div>
                        <?php if($post["PostImage"] != null): ?>
                            <div class="uk-margin-small">
                                <label><input class="uk-checkbox" type="checkbox" name="deleteimage"> Delete Image</label>
                            </div>
                        <?php endif ?>
                    </div>
                </fieldset>
                <?php if($errorFlag) : ?>
                    <div class="uk-text-center uk-text-danger">
                        An error has occurred, please try again.
                    </div>
                <?php endif ?>
                <div class="uk-flex uk-flex-center uk-text-center uk-flex-column">
                    <div class="uk-margin-small">
                        <button class="uk-button uk-button-primary" type="submit">Confirm Edit</button>
                    </div>
                    <div class="uk-margin-small">
                        <button class="uk-button uk-button-default" formaction="allposts.php">Back</button>
                        <button class="uk-button uk-button-danger" formaction="deletepost.php?postid=<?= $post["PostID"] ?>">Delete</button>
                    </div>  
                </div>
            </form>
        <?php else : ?>
            <span>Insufficient Permissions, back to <a href="index.php">home</a>.</span>
        <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>