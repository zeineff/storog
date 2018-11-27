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
                <label for="username"><?=$w["Account name"]?></label><br>
                <input type="text" name="username" id="username"><br><br>

                <label for="password"><?=$w["Password"]?></label><br>
                <input type="text" name="password" id="password"><br><br>

                <input type="submit" id="login_button" value="<?=$w["Login"]?>">
            </form>
        </main>
    </body>
</html>
