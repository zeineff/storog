<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    
    <body>
        <?php
            include "includes/header.php";
        ?>
        
        <main class="medium">
            <form id="register_form" action="functions/register.php" method="post">
                <label for="reg_username"><?=$w["Account name"]?></label><br>
                <input type="text" name="reg_username" id="reg_username"><br><br>

                <label for="reg_password_01"><?=$w["Password"]?></label><br>
                <input type="password" name="reg_password_01" id="reg_password_01"><br><br>

                <label for="reg_password_02"><?=$w["Re-enter Password"]?></label><br>
                <input type="password" name="reg_password_02" id="reg_password_02"><br><br>

                <input type="submit" id="register_button" value="<?=$w["Register"]?>">
            </form>
        </main>
    </body>
</html>
