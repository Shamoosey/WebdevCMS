<?php
    if(isset($_GET["username"])){

        header('Content-Type: application/json');
        require "connect.php";

        $username = filter_input(INPUT_GET, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = trim($username);
        $query = $db -> prepare("SELECT Username FROM users WHERE Username = '$username'");
        $query -> execute();
        $user = $query -> fetch();
    
        echo json_encode($user[0]);
    }
?>