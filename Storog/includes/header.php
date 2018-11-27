<?php
    require_once("functions/session.php");
    
    $page = $_SERVER['REQUEST_URI'];
    
    $query = filter_input(INPUT_GET, "query", FILTER_SANITIZE_STRING);
    $min_price = filter_input(INPUT_GET, "min_price", FILTER_SANITIZE_NUMBER_FLOAT);
    $max_price = filter_input(INPUT_GET, "max_price", FILTER_SANITIZE_NUMBER_FLOAT);
    
    $query = (isset($query) ? $query : "");
    
    if ($page !== "/Storog/register_form.php" && $page !== "/Storog/login_form.php"){
        $_SESSION["last_page"] = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
    }
?>

<script src="js/jquery-3.3.1.js"></script>
<script src="js/header.js"></script>
<link rel="stylesheet" type="text/css" href="css/header.css">

<div id="header">
    <div id="header_content" class="medium">
        <div id="logo">
            <a href="index.php"><img src="img/storog_logo.png" alt="store_logo"></a>
        </div>

        <div id="search">
            <form id="search_form" method="get" action="search.php">
                <input type="text" id="search_bar" name="query" placeholder="<?=$w["Search for games"]?>" value="<?=$query?>">
                <input type="submit" id="search_button" value="<?=$w["Search"]?>">
                <br/>

                <button id="advanced_search_button"><?=$w["Advanced Search"]?></button>

                <div id="advanced_search">
                    <label for="min_price"><?=$w["Minimum Price"]?></label>
                    <input type="number" step="0.01" id="min_price" name="min_price" <?php if (isset($min_price)){echo "value=" . $min_price;} ?>>
                    <br/>
                    <label for="max_price"><?=$w["Maximum Price"]?></label>
                    <input type="number" step="0.01" id="max_price" name="max_price"  <?php if (isset($max_price)){echo "value=" . $max_price;} ?>>
                </div>
            </form>
        </div>

        <div id="lang_select">
            <span id="lang_select_button"><?=$w["Language"]?> |</span>
            
            <div id="lang_select_box">
                <ul id="lang_select_list">
                    <li data-lang="en">
                        <img src="img/english.png" alt="English">
                        <a>English</a>
                    </li>
                    
                    <li data-lang="de">
                        <img src="img/german.png" alt="English">
                        <a>Deutsch</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div id="account_control">
            <?php if ($_SESSION["id"] === -1) : ?>
                <a href="login_form.php"><?=$w["Login"]?></a>
                <p style="display:inline-block"> | </p>
                <a href="register_form.php"><?=$w["Register"]?></a>
            <?php else : ?>
                <?=$_SESSION["username"]?>
                <a href="functions/logout.php">Logout</a>
            <?php endif ?>
        </div>
    </div>
</div>
