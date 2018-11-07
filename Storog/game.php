<?php
    include("functions/api_calls.php");
    
    $game_id = filter_input(INPUT_GET, "game_id", FILTER_SANITIZE_NUMBER_INT);
    $game = return_steam_game_info($game_id);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Storog</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    
    <body>
        <?php include "includes/header.php"; ?>
        
        <main class="thin">
            <h3 class="game_title"><?php echo $game["title"] ?></h3>
            
            <div id="game_top">
                <img src="<?php echo $game["image"] ?>" id="game_cover" alt="game_cover">

                <p id="game_description"><?php echo $game["description"] ?></p>
            </div>
            
            <ul id="stores">
                <li>Steam - <?php echo $game["price"] ?></li>
                <li>B</li>
                <li>C</li>
            </ul>
        </main>
    </body>
</html>
