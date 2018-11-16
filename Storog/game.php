<?php
    include("functions/functions.php");
    include("functions/api_calls.php");
    
    $game_id = filter_input(INPUT_GET, "game_id", FILTER_SANITIZE_NUMBER_INT);
    $game = get_game_by_id($game_id);
    $valid_game_id = !is_null($game);
    
    $steam_id = $game["steam_id"];
    $on_steam = !is_null($steam_id);
    $steam;
    
    $gog = return_gog_game($game["title"]);
    
    if ($on_steam){
        $steam = return_steam_game_info($game["steam_id"]);
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $game["title"] ?></title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/game.css">
    </head>
    
    <body>
        <?php include "includes/header.php"; ?>
        
        <main class="thin">
            <?php if (!$valid_game_id) : ?>
                <p>No game found with matching ID</p>
            <?php else : ?>
                <h3 id="title"><?php echo $game["title"] ?></h3>

                <div id="game_top">
                    <img src="<?php echo $steam["image"] ?>" id="cover" alt="game_cover">
                    
                    <div id="details">
                        <img id="header_img" src="<?php echo $steam["header_image"] ?>" alt="game_thumbnail">
                        
                        <p id="description"><?php echo $steam["description"] ?></p>
                        
                        <div id="flex_details">
                            <div id="release_date">
                                <p class="label">RELEASE DATE:</p>
                                <p><?php echo $steam["release_date"];?></p>
                            </div>

                            <div id="developers">
                                <p class="label">DEVELOPER:</p>
                                <ul id="developer_list">
                                    <?php foreach ($steam["developers"] as $d) : ?>
                                        <li class="developer"><?php echo $d ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <ul id="stores">
                    <?php if ($on_steam) : ?>
                        <li>
                            <a href="https://store.steampowered.com/app/<?php echo $steam_id ?>"><?php echo $steam["title"] ?> on Steam</a> - 
                            <?php
                                if ($steam["is_free"]){
                                    echo "Free";
                                }else{
                                    if ($steam["released"]){
                                        echo "€" . format_steam_price($steam["price"]);
                                    }else{
                                        echo "Not yet Released";
                                    }
                                }
                            ?>
                        </li>
                    <?php endif; ?>
                    
                        <li>
                            <a href="https://www.gog.com/game/<?= $gog["slug"] ?>"><?= $gog["title"] ?> on GOG</a>
                             - €<?= $gog["price"] ?>
                        </li>
                </ul>
            <?php endif; ?>
        </main>
    </body>
</html>
