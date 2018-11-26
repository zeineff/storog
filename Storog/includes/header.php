<?php
    require_once("functions/session.php");
    
    $page = $_SERVER['REQUEST_URI'];
    
    if ($page !== "/Storog/register_form.php" && $page !== "/Storog/login_form.php"){
        $_SESSION["last_page"] = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
    }
?>

<script src="js/jquery-3.3.1.js"></script>
<script src="js/header.js"></script>

<div id="header">
    <div id="header_content" class="medium">
        <div id="logo">
            <a href="index.php"><img src="img/storog_logo.png" alt="store_logo"></a>
        </div>

        <div id="search">
            <form id="search_form" method="get" action="search.php">
                <input type="text" id="search_bar" name="query">
                <input type="submit" id="search_button" value="Search">
                <br/>
                
                <button id="advanced_search_button">Advanced Search</button>
                
                <div id="advanced_search">
                    <label for="min_price">Minimum Price</label>
                    <input type="number" step="0.01" id="min_price" name="min_price">
                    <br/>
                    <label for="max_price">Maximum Price</label>
                    <input type="number" step="0.01" id="max_price" name="max_price">
                </div>
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
