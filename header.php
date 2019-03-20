<?php session_start() ?>
<header>
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
            <ul  class="uk-navbar-nav">
                <li>
                    <a href="#">Home</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li><a href="#">Test</a></li>
                            <li><a href="#">Test</a></li>
                            <li><a href="#">Test</a></li>
                            <li><a href="#">Test</a></li>
                        </ul>
                    </div>
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
                        <a href="#">Account</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="#">Account</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="actions/signout.php">Sign out</a></li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
</header>