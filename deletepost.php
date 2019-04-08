<?php
    $validUser = false;
    $admin = false;
    session_start();
    $postid = filter_input(INPUT_GET, "postid", FILTER_SANITIZE_NUMBER_INT);
    if(isset($_SESSION["ADMIN"])){
        $admin = $_SESSION["ADMIN"] == 1 ? true : false ;
    }

    require "actions/connect.php";
    $query = $db -> prepare("SELECT * FROM posts WHERE PostID = '$postid'");
    $query -> execute();
    $post = $query -> fetch();
    if(isset($_SESSION["USERID"])){
        if($_SESSION["USERID"] == $post["UserID"] || $admin){
            $validUser = true;
        }
    }

    if($validUser){
    
        $query = $db -> prepare("DELETE FROM posts WHERE PostID = '$postid'");
        $query -> execute();
    }
    header("location: allposts.php");
?>