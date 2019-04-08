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
                if(trim($_POST[$value]) != ""){
                    //pushing the value to the array
                    array_push($postFields, filter_input(INPUT_POST, $value ,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                } else {
                    $errorFlag = true;
                    $noSubmissionError = true;
                }
            } else {
                $noSubmissionError = true;
            }
        }
        if(isset($_POST['title'])){
            if(strlen($postFields[0]) > 25){
                $errorFlag = true;
                
            }
        }

        function file_upload_path($original_filename, $upload_subfolder_name = 'images') {
           $current_folder = dirname(__FILE__);
           $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
           return join(DIRECTORY_SEPARATOR, $path_segments);
        }

        function file_is_an_image($temporary_path, $new_path) {
            $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
            $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
            
            $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
            $actual_mime_type        = getimagesize($temporary_path)['mime'];
            
            $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
            $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
            
            return $file_extension_is_valid && $mime_type_is_valid;
        }
    
        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
        
        if ($image_upload_detected) {
            $image_filename       = $_FILES['image']['name'];
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path       = file_upload_path($image_filename);
            
            if (file_is_an_image($temporary_image_path, $new_image_path)) { 
                $imageName = "images\\" . basename($new_image_path);
                move_uploaded_file($temporary_image_path, $new_image_path);
            } else {
                $imageName = null;
                $errorFlag = true;
            }
        } else {
            $imageName = null;
        }

        if(!$errorFlag && !$noSubmissionError){
        require "actions/connect.php";
        $insert = "INSERT INTO posts (PostID, UserID, PostTitle, PostContent, PostImage) VALUES 
                                    (NULL, '$postFields[0]', '$postFields[1]', '$postFields[2]', :image)";
        $post = $db -> prepare($insert);
        $post -> bindvalue(':image', $imageName);
        $post -> execute();
            header("location: allposts.php");
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
        <h1 class="uk-text-center"><span>New Post</span></h1>
        <form action="newpost.php" method="post" enctype="multipart/form-data" class="uk-align-center">
            <div class="uk-flex uk-flex-center">
                <fieldset class="uk-fieldset">
                    <div class="uk-margin-small">
                        Title: <input class="uk-input" id="title" name="title" type="text" placeholder="Title" />
                    </div>

                    <div class="uk-margin-small">
                        Text: <textarea class="uk-textarea" rows="5" id="content" name="content" type="textarea" placeholder="Content"></textarea>
                    </div>
                    <div uk-form-custom="target: true">
                        <input type="file" name="image">
                        Image: <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
                </div>
            </fieldset>
            <?php if($errorFlag) : ?>
                <div class="uk-text-center uk-text-danger">
                    An error has occurred, please try again.
                </div>
            <?php endif ?>
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