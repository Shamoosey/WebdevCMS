<?php 
    $likeclause = "%";
    if(isset($_POST["search"])){
        $likeclause = trim(filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }
    
    require "actions/connect.php";
    $query = $db -> prepare("SELECT * FROM posts WHERE PostTitle LIKE '%{$likeclause}%'");
    $query -> execute();
    $posts = $query -> fetchAll();
    print_r($posts);
?>
<!DOCTYPE html>
<html>
<?php require "head.php" ?>
<body>
    <?php require "header.php" ?>
        <?php foreach ($posts as $post) : ?>
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title"><?= $post["PostTitle"]?></h3>
                <p>
                    <?= $post["PostContent"]?>
                </p>
            </div>
        <?php endforeach ?>
    <?php require "footer.php" ?>
</body>
</html>