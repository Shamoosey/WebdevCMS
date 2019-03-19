<header>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <?php if(isset($_SESSION["USERID"])): ?>
            <li class="nav-item">
                <a class="nav-link" href="actions/signout.php">Signout</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signup.php">Signup</a>
            </li>
            <?php endif ?>
        </ul>
    </nav>
</header>