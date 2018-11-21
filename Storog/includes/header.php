<?php
    require_once("functions/session.php");
    
    $page = $_SERVER['REQUEST_URI'];
    
    if ($page !== "/Storog/register_form.php" && $page !== "/Storog/login_form.php"){
        $_SESSION["last_page"] = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
    }
?>

<div id="header">
    <div id="header_content" class="medium">
        <div id="logo">
            <a href="index.php"><img src="img/steam_logo.png" alt="store_logo"></a>
        </div>

        <div id="search">
            <form id="search_form" method="get" action="search.php">
                <input type="text" id="search_bar" name="query">
                <input type="submit" id="search_button" value="Search">
                <br>
                <input type="number" id="min_price" name="min_price">
                <input type="number" id="max_price" name="max_price">
            </form>
        </div>

        <div id="account_control">
            <?php if ($_SESSION["id"] === -1) : ?>
                <a href="login_form.php">Login</a>
                <p style="display:inline-block"> | </p>
                <a href="register_form.php">Register</a>
            <?php else : ?>
                <?php echo $_SESSION["username"] ?>
                
                <a href="functions/logout.php">Logout</a>
            <?php endif ?>
        </div>
    </div>
</div>
