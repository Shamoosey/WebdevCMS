<!DOCTYPE html>
<html lang="en">
    <?php require "../head.php" ?>
    <body>
        <?php require  "../header.php" ?>
        <form id="signup" action="insert.php" method="post">
            <fieldset>
                <legend>Personal Information</legend>
                First Name: <input id="fname" name="fname" type="text" />
                <span class="addressError error" id="fname_error">* Required field</span><br/>

                Last Name: <input id="lname" name="lname" type="text" />
                <span class="addressError error" id="lname">* Required field</span><br/>

                Email: <input id="email" name="email" type="text" />
                <span class="addressError error" id="email_error">* Required field</span>
                <span class="addressError error" id="emailformat_error">* Invalid email address</span><br/>

            </fieldset>
            <fieldset>
            <legend>User Information</legend>
                UserName: <input id="username" name="username" type="text" />
                <span class="addressError error" id="username_error">* Required field</span>
                <span class="addressError error" id="usernameTaken_error">* Username taken</span>
            </fieldset>
            <button type="submit" id="submit">Book Appointment</button>
            <button type="reset" id="clear">Reset Fields</button>
        </form>
        <?php require "../footer.php" ?>
    </body>
</html>