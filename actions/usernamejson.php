<?php
    header('Content-Type: application/json');
    require "connect.php";
    $query = $db -> prepare("SELECT Username FROM users");
    $query -> execute();
    $user = $query -> fetchAll();

    json_encode($user);
?>