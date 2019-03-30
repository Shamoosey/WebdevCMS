<?php session_start(); ?>
<header>
    <nav class="uk-dark uk-navbar-container uk-text-bold uk-navbar-transparent" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-navbar-nav">
                <li><a class="" href="index.php">Home</a></li>
                <li><a class="" href="allposts.php">Posts</a></li>
            </ul>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav">
                <?php if(!isset($_SESSION["USERID"])): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign up</a></li>
                <?php else: ?>
                    <li>
                        <a href="account.php">User Account</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <?php if($_SESSION["ADMIN"] == 1) : ?>
                                <li><a href="admin.php">Admin Controls</a></li>
                                <?php endif ?>
                                <li><a href="newpost.php">New Post</a></li>
                                <li><a href="account.php">Account</a></li>
                                <li><a href="actions/signout.php">Sign out</a></li>
                            </ul>
                        </div>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
</header>