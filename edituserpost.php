<?php
    $nologin = false;
    $errorFlag = false;
    $noSubmissionError = false;
    $admin = false;
    $validuser = false;
    $postid = 0;
    $userID  = 0;

    $fields = ['title', 'content'];
    $postFields = array();
    session_start();

    require "actions/connect.php";
    
    if(isset($_GET["postid"])){
        $postid = filter_input(INPUT_GET, "postid", FILTER_SANITIZE_NUMBER_INT);
    } else {
        $errorFlag = true;
    }

    if(isset($_SESSION["ADMIN"])){
        $admin = $_SESSION["ADMIN"] == 1 ? true : false;
        $validuser = $admin ? true : false;
    }

    if(isset($_SESSION["USERID"])){
        $userID = $_SESSION["USERID"];
    }

    
    if(!$errorFlag && !$admin && !$validuser) {
        $query = $db -> prepare("SELECT UserID FROM posts WHERE PostID = '$postid'");
        $query -> execute();
        $user = $query -> fetch();
        if($user["UserID"] != $userID){
            $errorFlag = true;
        } else {
            $validuser = true;
        }
    }


    if(isset($_POST["deleteimage"])){
        if($_POST["deleteimage"] == "on"){
            $query = $db -> prepare("SELECT PostImage FROM posts WHERE PostID = '$postid'");
            $query -> execute();
            $post = $query -> fetch();

            if($post["PostImage"] != null){
                if(is_writable("images/".basename($post["PostImage"]))){
                    unlink("images/".basename($post["PostImage"]));

                    $query = $db -> prepare("UPDATE posts SET PostImage = null WHERE PostID = '$postid'");
                    $query -> execute();
                }
            }
        }
    }

    //checking if the user/admin is logged in
    if(isset($_SESSION["USERID"]) || $admin){
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

        if(!$errorFlag && !$noSubmissionError && $validuser){
        
        $query = $db -> prepare("UPDATE posts SET PostTitle = '$postFields[0]', PostContent = '$postFields[1]'
                                 WHERE PostID = '$postid'");
        $query -> execute();
            header("location: allposts.php");
        }

    }
    header("location: allposts.php");

?>