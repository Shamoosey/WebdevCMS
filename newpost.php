<?php
    $nologin = false;
    $errorFlag = false;
    $noSubmissionError = false;

    $fields = ['title', 'content'];
    $postFields = array();
    session_start();

    //checking if the user is logged in
    if(isset($_SESSION["USERID"])){
        array_push($postFields, $_SESSION["USERID"]);
        foreach ($fields as $value) {
            //Checking if the post is set
            if(isset($_POST[$value])){
                //checking if the post has anything in it
                if($_POST[$value] != ""){
                    //pushing the value to the array
                    array_push($postFields, filter_input(INPUT_POST, $value ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                } else {
                    $errorFlag = true;
                    $noSubmissionError = true;
                }
            } else {
                $noSubmissionError = true;
                $errorFlag = true;
            }
        }
        if(!$errorFlag){
            if(isset($_POST['imagelink'])){
                array_push($postFields, filter_input(INPUT_POST, 'imagelink' ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            } else {
                array_push($postFields, null);
            }

        require "actions/connect.php";
        $insert = "INSERT INTO posts (PostID, UserID, PostTitle, PostContent, PostImage) VALUES 
                                    (NULL, {$postFields[0]}, {$postFields[1]}, {$postFields[2]}, {$postFields[3]})";

        $post = $db -> prepare($insert);
        $post -> execute();
            header("location: index.php");
        }

    } else {
        $nologin = true;
    }
    session_abort();
?>
<!DOCTYPE html>
<html>
<?php require "head.php"?>
<body>
    <?php require "header.php" ?>
    <?php if(!$nologin): ?>
        <script>UPLOADCARE_PUBLIC_KEY = "d95019f4da90803c754b";</script>
        <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js" charset="utf-8"></script>

        <h1 class="uk-text-center"><span>New Post</span></h1>
        <form action="newpost.php" method="post" class="uk-align-center">
            <div class="uk-flex uk-flex-center">
                <fieldset class="uk-fieldset">
                    <div class="uk-margin-small">
                        Title: <input class="uk-input" id="title" name="title" type="text" placeholder="Title" />
                    </div>

                    <div class="uk-margin-small">
                        Text: <textarea class="uk-textarea" rows="5" id="content" name="content" type="textarea" placeholder="Content"></textarea>
                    </div>
                    <div class="uk-margin-small">
                        Link to Image: <input class="uk-input" id="imagelink" name="imagelink" type="text" placeholder="Image URL" />
                    </div>
                    Upload images <a target="_blank" href="https://imgur.com/upload">here</a>
                </div>
            </fieldset>

            <div class="uk-flex uk-flex-center uk-margin-top"> 
                <button class="uk-button-primary uk-button-small uk-margin-right" type="submit" id="submit">Post</button>
            </div>
        </form>
    <?php else :?>
        <p>You need to be <a href="login.php">signed in</a> to make a post.</p>
    <?php endif ?>
    <?php require "footer.php" ?>
</body>
</html>