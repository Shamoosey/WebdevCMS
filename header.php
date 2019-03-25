<?php session_start() ?>
<header>
    <nav class="uk-navbar-container uk-text-bold uk-navbar-transparent" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-light uk-navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="newpost.php">New Post</a></li>
            </ul>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav">
                <?php if(!isset($_SESSION["USERID"])): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign up</a></li>
                <?php else: ?>
                    <li>
                        <a href="account.php">Account</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
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