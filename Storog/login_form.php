<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    
    <body>
        <?php
            include "includes/header.php";
        ?>
        
        <main class="medium">
            <form id="login_form" action="functions/login.php" method="post">
                <label for="username">Account name</label><br>
                <input type="text" name="username" id="username"><br><br>

                <label for="password">Password</label><br>
                <input type="text" name="password" id="password"><br><br>

                <input type="submit" id="login_button" value="Sign in">
            </form>
        </main>
    </body>
</html>
