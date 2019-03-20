<?php session_start() ?>
<header>
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-navbar-nav">
                <li class="">
                    <a class="" href="index.php">Home</a>
                </li>
                <li class=" ">
                    <a class="" href="createpost.php">Post</a>
                </li>
            </ul>
        </div>
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav">
                    <?php if(!isset($_SESSION["USERID"])): ?>
                        <li>
                            <a href="login.php">Login</a>
                            <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="login.php">Login</a></li>
                                <li><a href="signup.php">Sign up</a></li>
                            </ul>
                            </div>
                        </li>
                    <?php else: ?>
                    <li>
                        <a href="actions/signout.php">Signout</a>
                    </li>
                </ul>
            </div>            
        <?php endif ?>
    </nav>
</header>